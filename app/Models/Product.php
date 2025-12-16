<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;
use Illuminate\Database\Eloquent\Relations\HasMany;

class Product extends Model
{
    use HasFactory;

    protected $fillable = [
        'name',
        'description',
        'website_url',
        'price',
        'images',
        'promotional_materials',
        'is_active',
    ];

    protected function casts(): array
    {
        return [
            'images' => 'array',
            'promotional_materials' => 'array',
            'is_active' => 'boolean',
        ];
    }

    public function programs(): BelongsToMany
    {
        return $this->belongsToMany(AffiliateProgram::class, 'program_products', 'product_id', 'program_id')
            ->withTimestamps();
    }

    public function trackingLinks(): HasMany
    {
        return $this->hasMany(TrackingLink::class);
    }

    public function isAssignedToProgram(): bool
    {
        return $this->programs()->exists();
    }
}
