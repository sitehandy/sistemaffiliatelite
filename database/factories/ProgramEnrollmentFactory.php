<?php

namespace Database\Factories;

use App\Models\AffiliateProgram;
use App\Models\ProgramEnrollment;
use App\Models\User;
use Illuminate\Database\Eloquent\Factories\Factory;

class ProgramEnrollmentFactory extends Factory
{
    protected $model = ProgramEnrollment::class;

    public function definition(): array
    {
        return [
            'user_id' => User::factory(),
            'affiliate_program_id' => AffiliateProgram::factory(),
            'status' => 'pending',
        ];
    }

    public function approved(): static
    {
        return $this->state(fn (array $attributes) => [
            'status' => 'approved',
            'approved_at' => now(),
        ]);
    }

    public function rejected(): static
    {
        return $this->state(fn (array $attributes) => [
            'status' => 'rejected',
        ]);
    }
}
