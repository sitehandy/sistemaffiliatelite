<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasOne;

class TrackingEvent extends Model
{
    use HasFactory;

    // Event Types
    public const EVENT_TYPE_CLICK = 'click';
    public const EVENT_TYPE_VIEW = 'view';
    public const EVENT_TYPE_CONVERSION = 'conversion';

    public const EVENT_TYPES = [
        self::EVENT_TYPE_CLICK,
        self::EVENT_TYPE_VIEW,
        self::EVENT_TYPE_CONVERSION,
    ];

    public $timestamps = false;

    protected $fillable = [
        'tracking_link_id',
        'event_type',
        'ip_address',
        'user_agent',
        'referrer',
        'metadata',
        'created_at',
    ];

    protected function casts(): array
    {
        return [
            'metadata' => 'array',
            'created_at' => 'datetime',
        ];
    }

    public function trackingLink(): BelongsTo
    {
        return $this->belongsTo(TrackingLink::class);
    }

    public function conversion(): HasOne
    {
        return $this->hasOne(Conversion::class);
    }

    public function isClick(): bool
    {
        return $this->event_type === self::EVENT_TYPE_CLICK;
    }

    public function isView(): bool
    {
        return $this->event_type === self::EVENT_TYPE_VIEW;
    }

    public function isConversion(): bool
    {
        return $this->event_type === self::EVENT_TYPE_CONVERSION;
    }
}
