<?php

namespace Database\Factories;

use App\Models\Program;
use Illuminate\Database\Eloquent\Factories\Factory;
use Illuminate\Support\Str;

class ProgramFactory extends Factory
{
    protected $model = Program::class;

    public function definition(): array
    {
        $name = fake()->unique()->words(3, true) . ' Program';

        return [
            'name' => $name,
            'slug' => Str::slug($name),
            'description' => fake()->paragraph(),
            'commission_type' => fake()->randomElement(['percentage', 'fixed']),
            'commission_value' => fake()->randomFloat(2, 5, 30),
            'cookie_duration' => fake()->numberBetween(7, 90),
            'min_payout' => fake()->randomFloat(2, 10, 100),
            'terms' => fake()->paragraphs(3, true),
            'is_active' => true,
            'requires_approval' => fake()->boolean(70),
        ];
    }

    public function inactive(): static
    {
        return $this->state(fn (array $attributes) => [
            'is_active' => false,
        ]);
    }

    public function active(): static
    {
        return $this->state(fn (array $attributes) => [
            'is_active' => true,
        ]);
    }

    public function percentage(): static
    {
        return $this->state(fn (array $attributes) => [
            'commission_type' => 'percentage',
        ]);
    }

    public function fixed(): static
    {
        return $this->state(fn (array $attributes) => [
            'commission_type' => 'fixed',
        ]);
    }

    public function noApprovalRequired(): static
    {
        return $this->state(fn (array $attributes) => [
            'requires_approval' => false,
        ]);
    }
}
