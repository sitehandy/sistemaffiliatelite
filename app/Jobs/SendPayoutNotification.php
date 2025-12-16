<?php

namespace App\Jobs;

use App\Mail\PayoutCompleted;
use App\Models\Payout;
use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Bus\Dispatchable;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Queue\SerializesModels;
use Illuminate\Support\Facades\Mail;

class SendPayoutNotification implements ShouldQueue
{
    use Dispatchable, InteractsWithQueue, Queueable, SerializesModels;

    public function __construct(public Payout $payout)
    {
    }

    public function handle(): void
    {
        if ($this->payout->status === 'completed') {
            Mail::to($this->payout->user->email)
                ->send(new PayoutCompleted($this->payout));
        }
    }
}
