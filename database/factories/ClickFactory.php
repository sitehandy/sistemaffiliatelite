<?php

namespace Database\Factories;

use App\Models\Click;
use App\Models\TrackingLink;
use Illuminate\Database\Eloquent\Factories\Factory;

class ClickFactory extends Factory
{
    protected $model = Click::class;

    public function definition(): array
    {
        return [
            'tracking_link_id' => TrackingLink::factory(),
            'ip_address' => fake()->ipv4(),
            'user_agent' => fake()->userAgent(),
            'referer' => fake()->url(),
            'landing_page' => fake()->url(),
            'country' => fake()->countryCode(),
            'city' => fake()->city(),
            'device_type' => fake()->randomElement(['desktop', 'mobile', 'tablet']),
            'browser' => fake()->randomElement(['Chrome', 'Firefox', 'Safari', 'Edge']),
            'os' => fake()->randomElement(['Windows', 'macOS', 'Linux', 'iOS', 'Android']),
            'is_unique' => fake()->boolean(70),
            'clicked_at' => fake()->dateTimeBetween('-30 days', 'now'),
        ];
    }
}
