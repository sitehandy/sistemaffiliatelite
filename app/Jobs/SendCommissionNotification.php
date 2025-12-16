<?php

namespace App\Jobs;

use App\Mail\CommissionApproved;
use App\Models\Commission;
use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Bus\Dispatchable;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Queue\SerializesModels;
use Illuminate\Support\Facades\Mail;

class SendCommissionNotification implements ShouldQueue
{
    use Dispatchable, InteractsWithQueue, Queueable, SerializesModels;

    public function __construct(public Commission $commission)
    {
    }

    public function handle(): void
    {
        if ($this->commission->status === 'approved') {
            Mail::to($this->commission->user->email)
                ->send(new CommissionApproved($this->commission));
        }
    }
}
