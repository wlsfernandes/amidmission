<?php

namespace App\Mail;

use Illuminate\Mail\Mailable;
use Illuminate\Mail\Mailables\Envelope;
use Illuminate\Mail\Mailables\Content;
use Illuminate\Queue\SerializesModels;

class PaymentEmail extends Mailable
{
    use SerializesModels;

    public string $type; // donation | cart
    public array $data;

    /**
     * Create a new message instance.
     */
    public function __construct(string $type, array $data)
    {
        $this->type = $type;
        $this->data = $data;
    }

    /**
     * Define the email envelope.
     */
    public function envelope(): Envelope
    {
        return new Envelope(
            subject: $this->type === 'donation'
                ? 'Thank you for your donation'
                : 'Your order confirmation'
        );
    }

    /**
     * Define the email content.
     */
    public function content(): Content
    {
        return new Content(
            view: 'emails.payment',
            with: [
                'type' => $this->type,
                'data' => $this->data,
            ]
        );
    }
}
