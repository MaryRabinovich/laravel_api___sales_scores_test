<?php

namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\OrderItem>
 */
class OrderItemFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition()
    {
        return [
            'order_id' => 1,
            'article' => $this->faker->unique()->word(5) . '-' . rand(1, 100),
            'name' => $this->faker->unique()->word(10),
            'price' => rand(1, 100),
            'quantity' => rand(1, 100),
        ];
    }
}
