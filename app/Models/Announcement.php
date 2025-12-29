<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Builder;

class Announcement extends Model
{
    // Type Constants
    public const TYPE_INFO = 'info';
    public const TYPE_WARNING = 'warning';
    public const TYPE_SUCCESS = 'success';
    public const TYPE_DANGER = 'danger';

    public const TYPES = [
        self::TYPE_INFO,
        self::TYPE_WARNING,
        self::TYPE_SUCCESS,
        self::TYPE_DANGER,
    ];

    protected $fillable = [
        'title',
        'content',
        'type',
        'is_active',
        'is_pinned',
        'published_at',
        'expires_at',
        'created_by',
    ];

    protected function casts(): array
    {
        return [
            'is_active' => 'boolean',
            'is_pinned' => 'boolean',
            'published_at' => 'datetime',
            'expires_at' => 'datetime',
        ];
    }

    public function author(): BelongsTo
    {
        return $this->belongsTo(User::class, 'created_by');
    }

    public function scopeActive(Builder $query): Builder
    {
        return $query->where('is_active', true)
            ->where(function ($q) {
                $q->whereNull('published_at')
                    ->orWhere('published_at', '<=', now());
            })
            ->where(function ($q) {
                $q->whereNull('expires_at')
                    ->orWhere('expires_at', '>', now());
            });
    }

    public function scopePinned(Builder $query): Builder
    {
        return $query->where('is_pinned', true);
    }

    public function isExpired(): bool
    {
        return $this->expires_at && $this->expires_at->isPast();
    }

    public function isPublished(): bool
    {
        if (!$this->is_active) {
            return false;
        }

        if ($this->published_at && $this->published_at->isFuture()) {
            return false;
        }

        if ($this->isExpired()) {
            return false;
        }

        return true;
    }
}
