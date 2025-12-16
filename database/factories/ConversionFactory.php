<?php

namespace Database\Factories;

use App\Models\Conversion;
use App\Models\TrackingLink;
use Illuminate\Database\Eloquent\Factories\Factory;

class ConversionFactory extends Factory
{
    protected $model = Conversion::class;

    public function definition(): array
    {
        return [
            'tracking_link_id' => TrackingLink::factory(),
            'type' => fake()->randomElement(['sale', 'lead']),
            'amount' => fake()->randomFloat(2, 10, 500),
            'order_id' => fake()->unique()->numerify('ORD-#####'),
            'status' => 'pending',
            'metadata' => null,
        ];
    }

    public function approved(): static
    {
        return $this->state(fn (array $attributes) => [
            'status' => 'approved',
        ]);
    }
}
