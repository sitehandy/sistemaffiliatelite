<?php

namespace App\Mail;

use App\Models\ProgramEnrollment;
use Illuminate\Bus\Queueable;
use Illuminate\Mail\Mailable;
use Illuminate\Mail\Mailables\Content;
use Illuminate\Mail\Mailables\Envelope;
use Illuminate\Queue\SerializesModels;

class EnrollmentApproved extends Mailable
{
    use Queueable, SerializesModels;

    public function __construct(public ProgramEnrollment $enrollment)
    {
    }

    public function envelope(): Envelope
    {
        return new Envelope(
            subject: 'Your enrollment has been approved - ' . $this->enrollment->program->name,
        );
    }

    public function content(): Content
    {
        return new Content(
            markdown: 'emails.enrollment-approved',
        );
    }
}
