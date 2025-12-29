<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class InstallationLog extends Model
{
    // Status Constants
    public const STATUS_PENDING = 'pending';
    public const STATUS_COMPLETED = 'completed';
    public const STATUS_FAILED = 'failed';

    public const STATUSES = [
        self::STATUS_PENDING,
        self::STATUS_COMPLETED,
        self::STATUS_FAILED,
    ];

    public $timestamps = false;

    protected $fillable = [
        'step',
        'status',
        'message',
        'details',
        'created_at',
    ];

    protected function casts(): array
    {
        return [
            'details' => 'array',
            'created_at' => 'datetime',
        ];
    }

    public function isPending(): bool
    {
        return $this->status === self::STATUS_PENDING;
    }

    public function isCompleted(): bool
    {
        return $this->status === self::STATUS_COMPLETED;
    }

    public function isFailed(): bool
    {
        return $this->status === self::STATUS_FAILED;
    }

    public function complete(string $message = null, array $details = null): void
    {
        $this->update([
            'status' => self::STATUS_COMPLETED,
            'message' => $message,
            'details' => $details,
        ]);
    }

    public function fail(string $message = null, array $details = null): void
    {
        $this->update([
            'status' => self::STATUS_FAILED,
            'message' => $message,
            'details' => $details,
        ]);
    }
}
