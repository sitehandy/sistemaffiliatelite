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

    // Payment Method Types
    public const TYPE_BANK = 'bank';
    public const TYPE_PAYPAL = 'paypal';
    public const TYPE_WISE = 'wise';

    public const TYPES = [
        self::TYPE_BANK,
        self::TYPE_PAYPAL,
        self::TYPE_WISE,
    ];

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
        return $this->type === self::TYPE_BANK;
    }

    public function isPaypal(): bool
    {
        return $this->type === self::TYPE_PAYPAL;
    }

    public function isWise(): bool
    {
        return $this->type === self::TYPE_WISE;
    }

    protected function maskedDetails(): Attribute
    {
        return Attribute::make(
            get: function () {
                $details = $this->details ?? [];

                return match ($this->type) {
                    self::TYPE_BANK => [
                        'bank_name' => $details['bank_name'] ?? '',
                        'account_number' => $this->maskString($details['account_number'] ?? ''),
                    ],
                    self::TYPE_PAYPAL => [
                        'email' => $this->maskEmail($details['email'] ?? ''),
                    ],
                    self::TYPE_WISE => [
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
