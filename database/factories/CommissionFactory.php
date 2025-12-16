<?php

namespace Database\Factories;

use App\Models\Commission;
use App\Models\Conversion;
use App\Models\User;
use Illuminate\Database\Eloquent\Factories\Factory;

class CommissionFactory extends Factory
{
    protected $model = Commission::class;

    public function definition(): array
    {
        return [
            'user_id' => User::factory(),
            'conversion_id' => Conversion::factory(),
            'amount' => fake()->randomFloat(2, 5, 100),
            'status' => 'pending',
        ];
    }

    public function approved(): static
    {
        return $this->state(fn (array $attributes) => [
            'status' => 'approved',
        ]);
    }

    public function paid(): static
    {
        return $this->state(fn (array $attributes) => [
            'status' => 'paid',
        ]);
    }
}
