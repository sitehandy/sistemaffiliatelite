<?php

namespace Database\Factories;

use App\Models\PaymentMethod;
use App\Models\User;
use Illuminate\Database\Eloquent\Factories\Factory;

class PaymentMethodFactory extends Factory
{
    protected $model = PaymentMethod::class;

    public function definition(): array
    {
        $type = fake()->randomElement(['paypal', 'bank_transfer', 'wise', 'crypto']);
        $details = match ($type) {
            'paypal' => ['email' => fake()->safeEmail()],
            'wise' => ['email' => fake()->safeEmail()],
            'bank_transfer' => [
                'bank_name' => fake()->company() . ' Bank',
                'account_name' => fake()->name(),
                'account_number' => fake()->bankAccountNumber(),
                'routing_number' => fake()->numerify('#########'),
            ],
            'crypto' => [
                'wallet_address' => '0x' . fake()->sha256(),
                'crypto_network' => fake()->randomElement(['ethereum', 'bitcoin', 'polygon']),
            ],
        };

        return [
            'user_id' => User::factory(),
            'type' => $type,
            'details' => $details,
            'is_primary' => false,
            'is_active' => true,
        ];
    }

    public function paypal(): static
    {
        return $this->state(fn (array $attributes) => [
            'type' => 'paypal',
            'details' => ['email' => fake()->safeEmail()],
        ]);
    }

    public function bankTransfer(): static
    {
        return $this->state(fn (array $attributes) => [
            'type' => 'bank_transfer',
            'details' => [
                'bank_name' => fake()->company() . ' Bank',
                'account_name' => fake()->name(),
                'account_number' => fake()->bankAccountNumber(),
                'routing_number' => fake()->numerify('#########'),
            ],
        ]);
    }

    public function primary(): static
    {
        return $this->state(fn (array $attributes) => [
            'is_primary' => true,
        ]);
    }
}
