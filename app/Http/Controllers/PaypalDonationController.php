<?php

namespace App\Http\Controllers;

use App\Models\Payment;
use Illuminate\Http\Request;

class PaypalDonationController extends Controller
{
    /**
     * Validate the donor form and store data in the session
     * so the PayPal JS SDK can open a payment for the correct amount.
     */
    public function startCheckout(Request $request)
    {
        $validated = $request->validate([
            'first_name' => 'required|string|max:255',
            'last_name'  => 'required|string|max:255',
            'email'      => 'required|email|max:255',
            'amount'     => 'required|numeric|min:1',
            'message'    => 'nullable|string|max:1000',
        ]);

        session(['paypal_donation' => $validated]);

        return response()->json(['ok' => true]);
    }

    /**
     * Called by the front-end after PayPal order is captured.
     * Creates the Payment record and returns a redirect URL.
     */
    public function complete(Request $request)
    {
        $request->validate([
            'paypal_order_id' => 'required|string|max:255',
        ]);

        $data = session('paypal_donation');

        if (! $data) {
            return response()->json(['error' => 'Session expired. Please fill in the form again.'], 422);
        }

        $currency = strtolower(config('services.paypal.currency', 'usd'));

        Payment::create([
            'payable_type' => null,
            'payable_id'   => null,
            'payment_type' => 'one_time',
            'status'       => 'completed',
            'amount'       => (int) round($data['amount'] * 100),
            'currency'     => $currency,
            'email'        => $data['email'],
            'first_name'   => $data['first_name'],
            'last_name'    => $data['last_name'],
            'metadata'     => [
                'paypal_order_id' => $request->paypal_order_id,
                'message'         => $data['message'] ?? null,
                'source'          => 'donation_form',
            ],
            'paid_at' => now(),
        ]);

        session()->forget('paypal_donation');

        return response()->json(['redirect' => route('donations.success')]);
    }

    /**
     * PayPal redirect-back success page (GET /donate/paypal/success).
     */
    public function success()
    {
        return redirect()->route('donations.success');
    }
}
