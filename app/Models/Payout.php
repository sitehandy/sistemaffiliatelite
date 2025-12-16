<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class Payout extends Model
{
    use HasFactory;

    protected $fillable = [
        'user_id',
        'total_amount',
        'commission_ids',
        'payment_method_id',
        'status',
        'transaction_reference',
        'notes',
        'processed_at',
    ];

    protected function casts(): array
    {
        return [
            'total_amount' => 'decimal:2',
            'commission_ids' => 'array',
            'processed_at' => 'datetime',
        ];
    }

    public function user(): BelongsTo
    {
        return $this->belongsTo(User::class);
    }

    public function paymentMethod(): BelongsTo
    {
        return $this->belongsTo(PaymentMethod::class);
    }

    public function commissions()
    {
        return Commission::whereIn('id', $this->commission_ids ?? []);
    }

    public function isPending(): bool
    {
        return $this->status === 'pending';
    }

    public function isProcessing(): bool
    {
        return $this->status === 'processing';
    }

    public function isCompleted(): bool
    {
        return $this->status === 'completed';
    }

    public function isFailed(): bool
    {
        return $this->status === 'failed';
    }

    public function startProcessing(): void
    {
        $this->update(['status' => 'processing']);
    }

    public function complete(string $transactionReference = null): void
    {
        $this->update([
            'status' => 'completed',
            'transaction_reference' => $transactionReference,
            'processed_at' => now(),
        ]);

        $this->commissions()->update(['status' => 'paid']);
    }

    public function fail(string $notes = null): void
    {
        $this->update([
            'status' => 'failed',
            'notes' => $notes,
        ]);
    }

    public function scopePending($query)
    {
        return $query->where('status', 'pending');
    }

    public function scopeProcessing($query)
    {
        return $query->where('status', 'processing');
    }

    public function scopeCompleted($query)
    {
        return $query->where('status', 'completed');
    }
}
