<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class InstallationLog extends Model
{
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
        return $this->status === 'pending';
    }

    public function isCompleted(): bool
    {
        return $this->status === 'completed';
    }

    public function isFailed(): bool
    {
        return $this->status === 'failed';
    }

    public function complete(string $message = null, array $details = null): void
    {
        $this->update([
            'status' => 'completed',
            'message' => $message,
            'details' => $details,
        ]);
    }

    public function fail(string $message = null, array $details = null): void
    {
        $this->update([
            'status' => 'failed',
            'message' => $message,
            'details' => $details,
        ]);
    }
}
