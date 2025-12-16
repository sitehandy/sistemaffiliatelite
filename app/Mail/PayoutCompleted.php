<?php

namespace App\Mail;

use App\Models\Payout;
use Illuminate\Bus\Queueable;
use Illuminate\Mail\Mailable;
use Illuminate\Mail\Mailables\Content;
use Illuminate\Mail\Mailables\Envelope;
use Illuminate\Queue\SerializesModels;

class PayoutCompleted extends Mailable
{
    use Queueable, SerializesModels;

    public function __construct(public Payout $payout)
    {
    }

    public function envelope(): Envelope
    {
        return new Envelope(
            subject: 'Payout Completed - $' . number_format($this->payout->total_amount, 2),
        );
    }

    public function content(): Content
    {
        return new Content(
            markdown: 'emails.payout-completed',
        );
    }
}
