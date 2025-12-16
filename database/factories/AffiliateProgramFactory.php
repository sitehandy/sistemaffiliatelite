<?php

namespace Database\Factories;

use App\Models\AffiliateProgram;
use App\Models\User;
use Illuminate\Database\Eloquent\Factories\Factory;

class AffiliateProgramFactory extends Factory
{
    protected $model = AffiliateProgram::class;

    public function definition(): array
    {
        return [
            'name' => fake()->words(3, true) . ' Program',
            'description' => fake()->sentence(),
            'program_type' => fake()->randomElement(['sale', 'view', 'lead']),
            'commission_type' => fake()->randomElement(['flat', 'percentage']),
            'commission_amount' => fake()->randomFloat(2, 1, 50),
            'visibility' => 'open',
            'is_active' => true,
            'created_by' => User::factory(),
        ];
    }

    public function inactive(): static
    {
        return $this->state(fn (array $attributes) => [
            'is_active' => false,
        ]);
    }

    public function pps(): static
    {
        return $this->state(fn (array $attributes) => [
            'type' => 'pps',
        ]);
    }

    public function percentage(): static
    {
        return $this->state(fn (array $attributes) => [
            'commission_type' => 'percentage',
        ]);
    }

    public function flat(): static
    {
        return $this->state(fn (array $attributes) => [
            'commission_type' => 'flat',
        ]);
    }
}
