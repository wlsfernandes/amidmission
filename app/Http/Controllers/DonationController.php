<?php
namespace App\Http\Controllers;

use App\Helpers\S3;
use App\Models\Donation;
use App\Services\SystemLogger;
use Exception;
use Illuminate\Http\Request;
use Stripe\Checkout\Session as CheckoutSession;
use Stripe\Stripe;

class DonationController extends BaseController
{

/* redirect to stripewebhookController*/
    public function startCheckout(Request $request, Donation $donation)
    {
        $validated = $request->validate([
            'amount'     => 'required|numeric|min:1',
            'email'      => 'required|email',
            'first_name' => 'required|string|max:255',
            'last_name'  => 'required|string|max:255',
            'country'    => 'nullable|string|max:255',
            'address'    => 'nullable|string|max:500',
        ]);

        SystemLogger::log(
            'Starting donation checkout',
            'info',
            'donations.checkout.start',
            [
                'donation_id' => $donation->id,
                'email'       => $validated['email'],
                'amount'      => $validated['amount'],
            ]
        );
        // ✅ Stripe v19 (same API, stricter validation)
        Stripe::setApiKey(config('services.stripe.secret'));

        $session = CheckoutSession::create([
            'mode'                 => 'payment',

            // Stripe Checkout handles PCI for you
            'payment_method_types' => ['card'],

            'line_items'           => [[
                'price_data' => [
                    'currency'     => 'usd',
                    'product_data' => [
                        'name' => $donation->title,
                    ],
                    // Stripe expects cents
                    'unit_amount'  => (int) ($validated['amount'] * 100),
                ],
                'quantity'   => 1,
            ]],

            // Prefill email in Stripe Checkout
            'customer_email'       => $validated['email'],

            'success_url'          => route('donations.success') . '?session_id={CHECKOUT_SESSION_ID}',
            'cancel_url'           => route('donations.checkout', $donation),

            // 🔑 CRITICAL: metadata for webhook routing
            'metadata'             => [
                'type'         => 'donation',
                'payable_type' => Donation::class,
                'payable_id'   => (string) $donation->id,

                'first_name'   => $validated['first_name'],
                'last_name'    => $validated['last_name'],
                'email'        => $validated['email'],
                'country'      => $validated['country'] ?? '',
                'address'      => $validated['address'] ?? '',
            ],
        ]);

        // Stripe v19 returns hosted Checkout URL
        return redirect()->away($session->url);
    }

/**
 * Validation rules
 * (Project standard: before store/update)
 */
    protected function validatedData(Request $request): array
    {
        return $request->validate([
            'title_en'         => ['required', 'string', 'max:255'],
            'title_es'         => ['required', 'string', 'max:255'],

            'description_en'   => ['nullable', 'string'],
            'description_es'   => ['nullable', 'string'],

            'suggested_amount' => ['nullable', 'numeric', 'min:0'],
            'currency'         => ['required', 'string', 'size:3'],

            'image_url'        => ['nullable', 'string'],

            'is_published'     => ['required', 'boolean'],
        ]);
    }

    /**
     * Display a listing of donations.
     */
    public function index()
    {
        $donations = Donation::orderBy('id')->get();

        return view('admin.donations.index', compact('donations'));
    }

    public function indexPublic()
    {
        $donations = Donation::where('is_published', true)
            ->orderBy('id')
            ->get();

        return view('frontend.donations.index', compact('donations'));
    }

    /**
     * Show the checkout page for a specific donation.
     */
    public function checkout(Request $request, Donation $donation)
    {
        return view('frontend.donations.checkout', [
            'donation' => $donation,
            'amount'   => $request->get('amount', $donation->suggested_amount),
        ]);
    }

    /**
     * Show the form for creating a new donation.
     */
    public function create()
    {
        return view('admin.donations.form');
    }

    /**
     * Store a newly created donation.
     */
    public function store(Request $request)
    {
        $data = $this->validatedData($request);

        try {
            $donation = Donation::create($data);

            SystemLogger::log(
                'Donation created',
                'info',
                'donations.store',
                [
                    'donation_id' => $donation->id,
                    'title'       => $donation->title,
                    'email'       => $request->email,
                ]
            );

            return redirect()
                ->route('donations.index')
                ->with('success', 'Donation created successfully.');

        } catch (Exception $e) {
            SystemLogger::log(
                'Donation creation failed',
                'error',
                'donations.store',
                [
                    'exception' => $e->getMessage(),
                    'email'     => $request->email,
                ]
            );

            return back()
                ->withInput()
                ->with('error', 'Failed to create donation.');
        }
    }

    /**
     * Show the form for editing the specified donation.
     */
    public function edit(Donation $donation)
    {
        return view('admin.donations.form', compact('donation'));
    }

    /**
     * Update the specified donation.
     */
    public function update(Request $request, Donation $donation)
    {
        $data = $this->validatedData($request);

        try {
            $donation->update($data);

            SystemLogger::log(
                'Donation updated',
                'info',
                'donations.update',
                [
                    'donation_id' => $donation->id,
                    'title'       => $donation->title,
                    'email'       => $request->email,
                ]
            );

            return redirect()
                ->route('donations.index')
                ->with('success', 'Donation updated successfully.');

        } catch (Exception $e) {
            SystemLogger::log(
                'Donation update failed',
                'error',
                'donations.update',
                [
                    'donation_id' => $donation->id,
                    'exception'   => $e->getMessage(),
                    'email'       => $request->email,
                ]
            );

            return back()
                ->withInput()
                ->with('error', 'Failed to update donation.');
        }
    }

    /**
     * Remove the specified donation.
     */
    public function destroy(Donation $donation)
    {
        try {
            // Cleanup image if exists
            if (! empty($donation->image_url)) {
                S3::delete($donation->image_url);
            }

            $donation->delete();

            SystemLogger::log(
                'Donation deleted',
                'warning',
                'donations.delete',
                [
                    'donation_id' => $donation->id,
                    'email'       => request()->email,
                ]
            );

            return redirect()
                ->route('donations.index')
                ->with('success', 'Donation deleted successfully.');

        } catch (Exception $e) {
            SystemLogger::log(
                'Donation deletion failed',
                'error',
                'donations.delete',
                [
                    'donation_id' => $donation->id,
                    'exception'   => $e->getMessage(),
                    'email'       => request()->email,
                ]
            );

            return back()
                ->with('error', 'Failed to delete donation.');
        }
    }
}
