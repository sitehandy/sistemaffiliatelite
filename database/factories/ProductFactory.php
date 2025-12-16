<?php

namespace Database\Factories;

use App\Models\Product;
use Illuminate\Database\Eloquent\Factories\Factory;

class ProductFactory extends Factory
{
    protected $model = Product::class;

    public function definition(): array
    {
        return [
            'name' => fake()->productName ?? fake()->words(2, true),
            'description' => fake()->paragraph(),
            'sku' => strtoupper(fake()->unique()->bothify('???-####')),
            'price' => fake()->randomFloat(2, 10, 500),
            'url' => fake()->url(),
            'image_url' => fake()->imageUrl(400, 300, 'products'),
            'is_active' => true,
        ];
    }

    public function inactive(): static
    {
        return $this->state(fn (array $attributes) => [
            'is_active' => false,
        ]);
    }
}
