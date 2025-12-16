<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasOne;

class Conversion extends Model
{
    use HasFactory;

    public $timestamps = false;

    protected $fillable = [
        'tracking_event_id',
        'conversion_value',
        'conversion_data',
        'order_id',
        'created_at',
    ];

    protected function casts(): array
    {
        return [
            'conversion_value' => 'decimal:2',
            'conversion_data' => 'array',
            'created_at' => 'datetime',
        ];
    }

    public function trackingEvent(): BelongsTo
    {
        return $this->belongsTo(TrackingEvent::class);
    }

    public function commission(): HasOne
    {
        return $this->hasOne(Commission::class);
    }

    public function getTrackingLink()
    {
        return $this->trackingEvent?->trackingLink;
    }

    public function getAffiliate()
    {
        return $this->getTrackingLink()?->user;
    }

    public function getProgram()
    {
        return $this->getTrackingLink()?->program;
    }
}
