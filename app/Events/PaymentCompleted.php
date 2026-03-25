<?php

namespace App\Events;

use Illuminate\Foundation\Events\Dispatchable;
use Illuminate\Queue\SerializesModels;

/* listener SendPaymentEmail */
class PaymentCompleted
{
    use Dispatchable, SerializesModels;

    public string $type; // donation | cart
    public array $data;

    public function __construct(string $type, array $data)
    {
        $this->type = $type;
        $this->data = $data;
    }
}
