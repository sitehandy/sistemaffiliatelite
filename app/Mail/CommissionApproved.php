<?php

namespace App\Mail;

use App\Models\Commission;
use Illuminate\Bus\Queueable;
use Illuminate\Mail\Mailable;
use Illuminate\Mail\Mailables\Content;
use Illuminate\Mail\Mailables\Envelope;
use Illuminate\Queue\SerializesModels;

class CommissionApproved extends Mailable
{
    use Queueable, SerializesModels;

    public function __construct(public Commission $commission)
    {
    }

    public function envelope(): Envelope
    {
        return new Envelope(
            subject: 'Commission Approved - $' . number_format($this->commission->amount, 2),
        );
    }

    public function content(): Content
    {
        return new Content(
            markdown: 'emails.commission-approved',
        );
    }
}
