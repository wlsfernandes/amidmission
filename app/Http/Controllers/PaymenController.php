<?php
namespace App\Http\Controllers;

use App\Models\Payment;
use Illuminate\View\View;

class PaymentController extends BaseController
{
    public function index(): View
    {
        $payments = Payment::with(['order'])
            ->orderByDesc('created_at')
            ->get();

        return view('admin.payments.index', compact('payments'));
    }

    public function show(Payment $payment): View
    {
        return view('admin.payments.show', compact('payment'));
    }
}
