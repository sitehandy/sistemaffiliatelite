<?php

namespace App\Jobs;

use App\Mail\EnrollmentApproved;
use App\Models\ProgramEnrollment;
use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Bus\Dispatchable;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Queue\SerializesModels;
use Illuminate\Support\Facades\Mail;

class SendEnrollmentNotification implements ShouldQueue
{
    use Dispatchable, InteractsWithQueue, Queueable, SerializesModels;

    public function __construct(public ProgramEnrollment $enrollment)
    {
    }

    public function handle(): void
    {
        if ($this->enrollment->status === 'approved') {
            Mail::to($this->enrollment->user->email)
                ->send(new EnrollmentApproved($this->enrollment));
        }
    }
}
