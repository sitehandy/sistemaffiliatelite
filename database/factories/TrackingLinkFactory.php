<?php

namespace Database\Factories;

use App\Models\ProgramEnrollment;
use App\Models\TrackingLink;
use App\Models\User;
use Illuminate\Database\Eloquent\Factories\Factory;
use Illuminate\Support\Str;

class TrackingLinkFactory extends Factory
{
    protected $model = TrackingLink::class;

    public function definition(): array
    {
        return [
            'user_id' => User::factory(),
            'program_enrollment_id' => ProgramEnrollment::factory(),
            'product_id' => null,
            'code' => Str::random(8),
            'name' => fake()->words(2, true),
            'custom_params' => null,
            'is_active' => true,
            'click_count' => 0,
            'conversion_count' => 0,
        ];
    }

    public function withClicks(int $count): static
    {
        return $this->state(fn (array $attributes) => [
            'click_count' => $count,
        ]);
    }

    public function withConversions(int $count): static
    {
        return $this->state(fn (array $attributes) => [
            'conversion_count' => $count,
        ]);
    }
}
