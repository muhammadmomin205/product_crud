<?php

namespace Database\Factories;

use App\Models\Product;
use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\Product>
 */
class ProductFactory extends Factory
{
    protected $model = Product::class;

    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        $categories = [
            'Electronics', 'Clothing', 'Home & Garden', 'Sports', 'Books',
            'Toys', 'Beauty', 'Automotive', 'Food', 'Health'
        ];

        $adjectives = [
            'Premium', 'Deluxe', 'Professional', 'Classic', 'Modern',
            'Vintage', 'Ultra', 'Smart', 'Eco', 'Compact'
        ];

        $products = [
            'Widget', 'Gadget', 'Device', 'Tool', 'Kit',
            'Set', 'Pack', 'Bundle', 'System', 'Unit'
        ];

        return [
            'name' => fake()->randomElement($adjectives) . ' ' . fake()->randomElement($categories) . ' ' . fake()->randomElement($products),
            'description' => fake()->paragraph(3),
            'price' => fake()->randomFloat(2, 5, 999),
            'quantity' => fake()->numberBetween(0, 500),
            'image' => null, // Will be set by seeder
        ];
    }
}
