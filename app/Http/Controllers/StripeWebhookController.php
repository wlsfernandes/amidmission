<?php
namespace App\Http\Controllers;

use App\Events\PaymentCompleted;
use App\Models\Donation;
use App\Models\Order;
use App\Models\Payment;
use App\Services\SystemLogger;
use Illuminate\Http\Request;
use Stripe\Webhook;

class StripeWebhookController extends BaseController
{
    public function handle(Request $request)
    {
        $payload   = $request->getContent();
        $sigHeader = $request->header('Stripe-Signature');

        try {
            $event = Webhook::constructEvent(
                $payload,
                $sigHeader,
                config('services.stripe.webhook_secret')
            );
            SystemLogger::log(
                'Stripe webhook received and verified',
                'info',
                'webhooks.stripe.received',
                [
                    'event_id'   => $event->id,
                    'event_type' => $event->type,
                ]
            );
        } catch (\Throwable $e) {
            SystemLogger::log(
                'Stripe webhook signature verification failed',
                'error',
                'webhooks.stripe.invalid_signature',
                [
                    'exception' => $e->getMessage(),
                    'payload'   => $payload,
                ]
            );
            return response()->json(['error' => 'Invalid signature'], 400);
        }

        match ($event->type) {
            'checkout.session.completed' => $this->handleCheckoutCompleted($event),
            default                      => null,
        };

        return response()->json(['status' => 'ok']);
    }

    protected function handleCheckoutCompleted($event): void
    {
        $session = $event->data->object;
        $type    = $session->metadata->type ?? null;
        match ($type) {
            'donation' => $this->processDonation($session),
            'cart'     => $this->processCart($session),
            default    => null,
        };
    }

    protected function processDonation($session): void
{
    try {

        $payment = Payment::create([
            // Stripe references
            'stripe_session_id'        => $session->id,
            'stripe_payment_intent_id' => $session->payment_intent ?? null,
            'stripe_customer_id'       => $session->customer ?? null,

            // Payment details
            'payment_type' => 'donation',
            'status'       => 'completed',

            // Amount (convert cents → dollars if needed)
            'amount'   => $session->amount_total / 100,
            'currency' => strtoupper($session->currency),

            // Customer
            'email' => $session->customer_email,
            'name'  => $session->metadata->name ?? 'Guest',

            // Metadata (optional)
            'metadata' => $session->metadata,

            'paid_at' => now(),
        ]);

        // Optional: event (email, notifications, etc.)
       /* event(new PaymentCompleted('donation', [
            'email'    => $payment->email,
            'name'     => $payment->name,
            'amount'   => number_format($payment->amount, 2),
            'currency' => $payment->currency,
        ])); */

    } catch (\Throwable $e) {

        // Keep it simple (you can log if needed)
        \Log::error('Donation processing failed', [
            'error' => $e->getMessage(),
            'session_id' => $session->id ?? null,
        ]);

        // Do NOT throw (important for Stripe webhook)
    }
}

    /*  * Process a completed checkout session for a cart purchase
     * @param object $session The Stripe checkout session object
     * @return void
     */

    protected function processCart($session): void
    {
        try {

            SystemLogger::log(
                'Processing cart payment',
                'info',
                'payments.cart.processing',
                [
                    'session_id' => $session->id,
                ]
            );
            // ----------------------------------
            // Idempotency
            // ----------------------------------
            if (Payment::where('stripe_session_id', $session->id)->exists()) {
                SystemLogger::log(
                    'Cart payment already recorded (duplicate webhook ignored)',
                    'info',
                    'payments.cart.duplicate',
                    [
                        'stripe_session_id' => $session->id,
                    ]
                );
                return;
            }

            // ----------------------------------
            // Decode cart safely
            // ----------------------------------
            $cart = [];

            if (! empty($session->metadata->cart)) {
                $cart = json_decode($session->metadata->cart, true) ?? [];
            }

            if (empty($cart)) {
                throw new \Exception('Cart metadata is empty or invalid.');
            }

            $shipping = (int) round(((float) ($session->metadata->shipping ?? 0)) * 100);

            $subtotal = collect($cart)->sum(function ($item) {
                return (int) ($item['price'] * 100) * (int) $item['quantity'];
            });

            // ----------------------------------
            // Create Payment + Order + Order Items
            // ----------------------------------

            $payment = Payment::create([
                // Polymorphic target (temporary until order exists)
                'payable_type'             => null,
                'payable_id'               => null,

                // Stripe references
                'stripe_session_id'        => $session->id,
                'stripe_payment_intent_id' => $session->payment_intent ?? null,
                'stripe_customer_id'       => $session->customer ?? null,

                // Payment info
                'payment_type'             => 'one_time',
                'status'                   => 'completed',

                // Amounts are stored in cents
                'amount'                   => $session->amount_total,
                'currency'                 => $session->currency,

                // Customer snapshot
                'email'                    => $session->customer_email,
                'first_name'               => $session->metadata->first_name ?? null,
                'last_name'                => $session->metadata->last_name ?? null,
                'country'                  => $session->metadata->country ?? null,
                'address'                  => $session->metadata->address ?? null,

                'metadata'                 => $session->metadata,
                'paid_at'                  => now(),
            ]);

            $order = Order::create([
                'status'     => 'paid',
                'subtotal'   => $subtotal,
                'shipping'   => $shipping,
                'total'      => $session->amount_total,
                'currency'   => $session->currency,

                'email'      => $session->customer_email,
                'first_name' => $session->metadata->first_name ?? null,
                'last_name'  => $session->metadata->last_name ?? null,
                'country'    => $session->metadata->country ?? null,
                'address'    => $session->metadata->address ?? null,

                'metadata'   => $session->metadata,
            ]);

            // ----------------------------------
            // Order Items
            // ----------------------------------
            foreach ($cart as $item) {
                $order->items()->create([
                    'product_id'   => $item['product_id'],
                    'product_name' => $item['name'],
                    'price'        => (int) ($item['price'] * 100),
                    'quantity'     => (int) $item['quantity'],
                    'currency'     => $item['currency'],
                ]);
            }
/* send email notification (wrapped in...) */

            try {
                $payload = [
                    'email'    => $session->customer_email,
                    'name'     => trim(($session->metadata->first_name ?? '') . ' ' . ($session->metadata->last_name ?? '')),
                    'amount'   => number_format($session->amount_total / 100, 2),
                    'currency' => strtoupper($session->currency ?? 'USD'),
                    // Optional but useful
                    'order_id' => $order->id ?? null,
                    'items'    => collect($cart)->map(fn($item) =>
                        $item['name'] . ' × ' . $item['quantity']
                    )->toArray(),
                ];
                event(new PaymentCompleted('cart', $payload));

            } catch (\Throwable $e) {
                SystemLogger::log(
                    'Failed to dispatch PaymentCompleted event',
                    'error',
                    'events.payment_completed.failed',
                    [
                        'exception'  => $e->getMessage(),
                        'payment_id' => $payment->id,
                    ]
                );
            }
            // ----------------------------------
            // Attach Payment → Order
            // ----------------------------------
            Payment::where('stripe_session_id', $session->id)->update([
                'order_id'     => $order->id,
                'payable_type' => Order::class,
                'payable_id'   => $order->id,
            ]);

            SystemLogger::log(
                'Order created after cart payment',
                'info',
                'orders.created',
                [
                    'order_id'    => $order->id,
                    'items_count' => count($cart),
                    'total'       => $session->amount_total,
                ]
            );

        } catch (\Throwable $e) {

            SystemLogger::log(
                'Cart payment processing failed',
                'error',
                'payments.cart.failed',
                [
                    'exception'         => $e->getMessage(),
                    'stripe_session_id' => $session->id ?? null,
                    'email'             => $session->customer_email ?? null,
                    'payload'           => $session,
                ]
            );
        }
    }

}
