<?php

namespace App\Jobs;

use App\Mail\PayoutCompleted;
use App\Models\Payout;
use App\Models\SystemSetting;
use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Bus\Dispatchable;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Queue\SerializesModels;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Mail;

class ProcessPayouts implements ShouldQueue
{
    use Dispatchable, InteractsWithQueue, Queueable, SerializesModels;

    public function handle(): void
    {
        $pendingPayouts = Payout::pending()
            ->with(['user', 'paymentMethod'])
            ->get();

        foreach ($pendingPayouts as $payout) {
            try {
                // Mark as processing
                $payout->process();

                // Here you would integrate with actual payment providers
                // For now, we'll just log and mark as completed
                Log::info("Processing payout #{$payout->id} for user {$payout->user->email}", [
                    'amount' => $payout->total_amount,
                    'method' => $payout->paymentMethod?->type,
                ]);

                // In production, you would:
                // 1. Call payment provider API (PayPal, Wise, etc.)
                // 2. Wait for confirmation
                // 3. Update status based on response

            } catch (\Exception $e) {
                Log::error("Failed to process payout #{$payout->id}: " . $e->getMessage());
                $payout->fail($e->getMessage());
            }
        }
    }
}
