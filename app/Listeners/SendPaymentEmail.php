<?php

namespace App\Listeners;

use App\Events\PaymentCompleted;
use App\Mail\PaymentEmail;
use Illuminate\Support\Facades\Mail;

class SendPaymentEmail
{
    public function handle(PaymentCompleted $event): void
    {
        Mail::to($event->data['email'])
            ->send(new PaymentEmail(
                $event->type,
                $event->data
            ));
    }
}
