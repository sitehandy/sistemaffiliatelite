<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\Casts\Attribute;

class PaymentMethod extends Model
{
    use HasFactory;

    protected $fillable = [
        'user_id',
        'type',
        'details',
        'is_active',
        'is_verified',
    ];

    protected function casts(): array
    {
        return [
            'details' => 'encrypted:array',
            'is_active' => 'boolean',
            'is_verified' => 'boolean',
        ];
    }

    public function user(): BelongsTo
    {
        return $this->belongsTo(User::class);
    }

    public function payouts(): HasMany
    {
        return $this->hasMany(Payout::class);
    }

    public function isBank(): bool
    {
        return $this->type === 'bank';
    }

    public function isPaypal(): bool
    {
        return $this->type === 'paypal';
    }

    public function isWise(): bool
    {
        return $this->type === 'wise';
    }

    protected function maskedDetails(): Attribute
    {
        return Attribute::make(
            get: function () {
                $details = $this->details ?? [];

                return match ($this->type) {
                    'bank' => [
                        'bank_name' => $details['bank_name'] ?? '',
                        'account_number' => $this->maskString($details['account_number'] ?? ''),
                    ],
                    'paypal' => [
                        'email' => $this->maskEmail($details['email'] ?? ''),
                    ],
                    'wise' => [
                        'email' => $this->maskEmail($details['email'] ?? ''),
                    ],
                    default => [],
                };
            }
        );
    }

    private function maskString(string $value): string
    {
        $length = strlen($value);
        if ($length <= 4) {
            return str_repeat('*', $length);
        }
        return str_repeat('*', $length - 4) . substr($value, -4);
    }

    private function maskEmail(string $email): string
    {
        $parts = explode('@', $email);
        if (count($parts) !== 2) {
            return $this->maskString($email);
        }

        $name = $parts[0];
        $domain = $parts[1];

        if (strlen($name) <= 2) {
            return $name . '@' . $domain;
        }

        return substr($name, 0, 2) . str_repeat('*', strlen($name) - 2) . '@' . $domain;
    }
}
