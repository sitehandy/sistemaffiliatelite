<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Support\Str;

class AffiliateProgram extends Model
{
    use HasFactory;

    // Program Types
    public const PROGRAM_TYPE_SALE = 'sale';
    public const PROGRAM_TYPE_VIEW = 'view';
    public const PROGRAM_TYPE_LEAD = 'lead';

    public const PROGRAM_TYPES = [
        self::PROGRAM_TYPE_SALE,
        self::PROGRAM_TYPE_VIEW,
        self::PROGRAM_TYPE_LEAD,
    ];

    // Commission Types
    public const COMMISSION_TYPE_FLAT = 'flat';
    public const COMMISSION_TYPE_PERCENTAGE = 'percentage';

    public const COMMISSION_TYPES = [
        self::COMMISSION_TYPE_FLAT,
        self::COMMISSION_TYPE_PERCENTAGE,
    ];

    // Visibility
    public const VISIBILITY_HIDDEN = 'hidden';
    public const VISIBILITY_OPEN = 'open';

    public const VISIBILITIES = [
        self::VISIBILITY_HIDDEN,
        self::VISIBILITY_OPEN,
    ];

    protected $fillable = [
        'name',
        'description',
        'program_type',
        'commission_type',
        'commission_amount',
        'visibility',
        'invitation_code',
        'default_url',
        'created_by',
        'is_active',
    ];

    protected function casts(): array
    {
        return [
            'commission_amount' => 'decimal:2',
            'is_active' => 'boolean',
        ];
    }

    protected static function booted(): void
    {
        static::creating(function (AffiliateProgram $program) {
            if ($program->visibility === self::VISIBILITY_HIDDEN && !$program->invitation_code) {
                $program->invitation_code = Str::random(16);
            }
        });
    }

    public function creator(): BelongsTo
    {
        return $this->belongsTo(User::class, 'created_by');
    }

    public function products(): BelongsToMany
    {
        return $this->belongsToMany(Product::class, 'program_products', 'program_id', 'product_id')
            ->withTimestamps();
    }

    public function enrollments(): HasMany
    {
        return $this->hasMany(ProgramEnrollment::class, 'program_id');
    }

    public function trackingLinks(): HasMany
    {
        return $this->hasMany(TrackingLink::class, 'program_id');
    }

    public function conversions()
    {
        return Conversion::whereHas('trackingEvent.trackingLink', function ($query) {
            $query->where('program_id', $this->id);
        });
    }

    public function getConversionsCountAttribute(): int
    {
        return $this->conversions()->count();
    }

    public function approvedAffiliates()
    {
        return $this->belongsToMany(User::class, 'program_enrollments', 'program_id', 'user_id')
            ->wherePivot('status', ProgramEnrollment::STATUS_APPROVED);
    }

    public function isOpen(): bool
    {
        return $this->visibility === self::VISIBILITY_OPEN;
    }

    public function isHidden(): bool
    {
        return $this->visibility === self::VISIBILITY_HIDDEN;
    }

    public function calculateCommission(float $value): float
    {
        if ($this->commission_type === self::COMMISSION_TYPE_FLAT) {
            return (float) $this->commission_amount;
        }

        return $value * ((float) $this->commission_amount / 100);
    }
}
