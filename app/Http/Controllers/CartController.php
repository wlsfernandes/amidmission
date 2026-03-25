<?php
namespace App\Http\Controllers;

use App\Models\Product;
use Illuminate\Http\Request;
use Stripe\Checkout\Session as CheckoutSession;
use Stripe\Stripe;

class CartController extends Controller
{

    public function show()
    {
        $cart      = session()->get('cart', []);
        $cartTotal = collect($cart)->sum(fn($item) => $item['price'] * $item['quantity']);

        return view('payment.cart', compact('cart', 'cartTotal'));
    }

    public function index()
    {
        $cart = session()->get('cart', []);

        $subtotal = $this->calculateSubtotal($cart);
        $shipping = $this->calculateShipping($cart);
        $total    = $subtotal + $shipping;

        return view('frontend.cart.index', compact(
            'cart',
            'subtotal',
            'shipping',
            'total'
        ));
    }

    public function add(Request $request, Product $product)
    {
        $validated = $request->validate([
            'quantity' => 'required|integer|min:1',
        ]);

        $cart = session()->get('cart', []);

        if (isset($cart[$product->id])) {
            $cart[$product->id]['quantity'] += $validated['quantity'];
        } else {
            $cart[$product->id] = [
                'product_id' => $product->id,
                'name'       => $product->name,
                'price'      => (float) $product->price,
                'currency'   => $product->currency,
                'quantity'   => (int) $validated['quantity'],
                'image'      => route('admin.images.preview', [
                    'model' => 'products',
                    'id'    => $product->id,
                ]),
                'is_digital' => (bool) $product->is_digital,
            ];
        }

        session()->put('cart', $cart);

        return redirect()
            ->route('cart.index')
            ->with('success', 'Product added to cart.');
    }

    public function remove(Request $request, int $productId)
    {
        $cart = session()->get('cart', []);

        if (isset($cart[$productId])) {
            unset($cart[$productId]);
            session()->put('cart', $cart);
        }

        return redirect()
            ->back()
            ->with('success', 'Item removed from cart.');
    }

    /* -------------------------------------------------
     |  Helpers
     | -------------------------------------------------
     */

    protected function calculateSubtotal(array $cart): float
    {
        return collect($cart)->sum(function ($item) {
            return (float) $item['price'] * (int) $item['quantity'];
        });
    }

    protected function calculateShipping(array $cart): float
    {
        $shippingPerItem = 3.99;

        return collect($cart)
            ->where('is_digital', false)
            ->sum(fn($item) => $shippingPerItem * (int) $item['quantity']);
    }

    /* -------------------------------------------------
     |  Checkout Sucess Redirect
     | -------------------------------------------------
     */
    public function success(Request $request)
    {

        // ✅ CLEAR CART SESSION
        session()->forget('cart');

        // Optional: flash message
        session()->flash('success', 'Thank you! Your order was completed.');

        return view('frontend.cart.success');
    }

    /*
    * Start Stripe Checkout for Cart
      */
    public function checkout(Request $request)
    {
        $validated = $request->validate([
            'email'      => 'required|email',
            'first_name' => 'required|string|max:255',
            'last_name'  => 'required|string|max:255',
            'country'    => 'nullable|string|max:255',
            'address'    => 'nullable|string|max:500',
        ]);

        $cart = session()->get('cart', []);

        abort_if(empty($cart), 400, 'Cart is empty.');

        // ---------------------------------------
        // Build Stripe line items from cart
        // ---------------------------------------
        $lineItems = [];

        foreach ($cart as $item) {
            $lineItems[] = [
                'price_data' => [
                    'currency'     => 'usd',
                    'product_data' => [
                        'name' => $item['name'],
                    ],
                    'unit_amount'  => (int) ((float) $item['price'] * 100),
                ],
                'quantity'   => (int) $item['quantity'],
            ];
        }

        // ---------------------------------------
        // Shipping: $3.99 per physical item
        // ---------------------------------------
        $shipping = collect($cart)
            ->where('is_digital', false)
            ->sum(fn($item) => 3.99 * (int) $item['quantity']);

        if ($shipping > 0) {
            $lineItems[] = [
                'price_data' => [
                    'currency'     => 'usd',
                    'product_data' => [
                        'name' => 'Shipping',
                    ],
                    'unit_amount'  => (int) ($shipping * 100),
                ],
                'quantity'   => 1,
            ];
        }

        // ---------------------------------------
        // Stripe v19
        // ---------------------------------------
        Stripe::setApiKey(config('services.stripe.secret'));

        $session = CheckoutSession::create([
            'mode'                 => 'payment',
            'payment_method_types' => ['card'],

            'line_items'           => $lineItems,

            'customer_email'       => $validated['email'],

            'success_url'          => route('cart.success') . '?session_id={CHECKOUT_SESSION_ID}',
            'cancel_url'           => route('cart.index'),

            // ---------------------------------------
            // Metadata snapshot for webhook
            // ---------------------------------------
            'metadata'             => [
                'type'       => 'cart',
                'email'      => $validated['email'],
                'first_name' => $validated['first_name'],
                'last_name'  => $validated['last_name'],
                'country'    => $validated['country'] ?? '',
                'address'    => $validated['address'] ?? '',
                'cart'       => json_encode($cart),
                'shipping'   => (string) $shipping,
            ],
        ]);

        return redirect()->away($session->url);
    }

}
