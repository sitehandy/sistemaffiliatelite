<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\Cache;

class SystemSetting extends Model
{
    protected $fillable = [
        'key',
        'value',
        'type',
        'is_public',
    ];

    protected function casts(): array
    {
        return [
            'is_public' => 'boolean',
        ];
    }

    public static function get(string $key, mixed $default = null): mixed
    {
        $setting = Cache::remember("system_setting_{$key}", 3600, function () use ($key) {
            return static::where('key', $key)->first();
        });

        if (!$setting) {
            return $default;
        }

        return $setting->getCastedValue();
    }

    public static function getValue(string $key, mixed $default = null): mixed
    {
        return static::get($key, $default);
    }

    public static function set(string $key, mixed $value, string $type = 'string', bool $isPublic = false): void
    {
        $setting = static::updateOrCreate(
            ['key' => $key],
            [
                'value' => is_array($value) ? json_encode($value) : (string) $value,
                'type' => $type,
                'is_public' => $isPublic,
            ]
        );

        Cache::forget("system_setting_{$key}");
    }

    public function getCastedValue(): mixed
    {
        return match ($this->type) {
            'integer' => (int) $this->value,
            'boolean' => filter_var($this->value, FILTER_VALIDATE_BOOLEAN),
            'json' => json_decode($this->value, true),
            default => $this->value,
        };
    }

    public static function getPublic(): array
    {
        return Cache::remember('system_settings_public', 3600, function () {
            return static::where('is_public', true)
                ->get()
                ->mapWithKeys(fn ($setting) => [$setting->key => $setting->getCastedValue()])
                ->toArray();
        });
    }
}
