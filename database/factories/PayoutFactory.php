<?php

namespace Database\Factories;

use App\Models\PaymentMethod;
use App\Models\Payout;
use App\Models\User;
use Illuminate\Database\Eloquent\Factories\Factory;

class PayoutFactory extends Factory
{
    protected $model = Payout::class;

    public function definition(): array
    {
        $amount = fake()->randomFloat(2, 50, 1000);
        $fee = $amount * 0.02;

        return [
            'user_id' => User::factory(),
            'payment_method_id' => PaymentMethod::factory(),
            'amount' => $amount,
            'fee' => $fee,
            'total_amount' => $amount - $fee,
            'status' => 'pending',
            'transaction_id' => null,
            'processed_at' => null,
            'notes' => null,
        ];
    }

    public function pending(): static
    {
        return $this->state(fn (array $attributes) => [
            'status' => 'pending',
        ]);
    }

    public function approved(): static
    {
        return $this->state(fn (array $attributes) => [
            'status' => 'approved',
        ]);
    }

    public function completed(): static
    {
        return $this->state(fn (array $attributes) => [
            'status' => 'completed',
            'transaction_id' => 'TXN-' . fake()->unique()->numerify('######'),
            'processed_at' => fake()->dateTimeBetween('-7 days', 'now'),
        ]);
    }

    public function failed(): static
    {
        return $this->state(fn (array $attributes) => [
            'status' => 'failed',
            'notes' => fake()->sentence(),
        ]);
    }
}
