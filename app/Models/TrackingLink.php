<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Support\Str;

class TrackingLink extends Model
{
    use HasFactory;

    protected $fillable = [
        'user_id',
        'product_id',
        'program_id',
        'unique_code',
        'tracking_url',
    ];

    protected static function booted(): void
    {
        static::creating(function (TrackingLink $link) {
            if (!$link->unique_code) {
                $link->unique_code = self::generateUniqueCode();
            }

            if (!$link->tracking_url) {
                $link->tracking_url = config('app.url') . '/track/' . $link->unique_code;
            }
        });
    }

    public static function generateUniqueCode(): string
    {
        do {
            $code = Str::random(16);
        } while (self::where('unique_code', $code)->exists());

        return $code;
    }

    public function user(): BelongsTo
    {
        return $this->belongsTo(User::class);
    }

    public function product(): BelongsTo
    {
        return $this->belongsTo(Product::class);
    }

    public function program(): BelongsTo
    {
        return $this->belongsTo(AffiliateProgram::class, 'program_id');
    }

    public function events(): HasMany
    {
        return $this->hasMany(TrackingEvent::class);
    }

    public function trackingEvents(): HasMany
    {
        return $this->hasMany(TrackingEvent::class);
    }

    public function clicks()
    {
        return $this->events()->where('event_type', 'click');
    }

    public function views()
    {
        return $this->events()->where('event_type', 'view');
    }

    public function conversions()
    {
        return $this->events()->where('event_type', 'conversion');
    }

    public function getClickCountAttribute(): int
    {
        return $this->clicks()->count();
    }

    public function getConversionCountAttribute(): int
    {
        return $this->conversions()->count();
    }
}
