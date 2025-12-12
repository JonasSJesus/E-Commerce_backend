<?php
declare(strict_types=1);

namespace Database\Factories;

use App\Models\Category;
use App\Models\Product;
use Illuminate\Database\Eloquent\Factories\Factory;
use Illuminate\Support\Carbon;

class ProductFactory extends Factory
{
    protected $model = Product::class;

    public function definition(): array
    {
        return [
            'price'               => $this->faker->randomFloat(2, 1, 500),
            'cost_price'          => $this->faker->randomFloat(2, 0.50, 500),
            'stock_quantity'      => $this->faker->numberBetween(0, 100),
            'low_stock_threshold' => $this->faker->numberBetween(1, 10),
            'active'              => true,
            'category_id'         => null,
            'created_at'          => Carbon::now(),
        ];
    }

    public function withCategory(): static
    {
        return $this->state(function (array $attributes) {
            return [
                'category_id' => Category::factory(),
            ];
        });
    }

    /**
     * Indicate that the product is inactive.
     */
    public function inactive(): static
    {
        return $this->state(fn (array $attributes) => [
            'active' => false,
        ]);
    }

    /**
     * Indicate that the product is out of stock.
     */
    public function outOfStock(): static
    {
        return $this->state(fn (array $attributes) => [
            'stock_quantity' => 0,
        ]);
    }


    /**
     * Create expensive products
     */
    public function expensive(): static
    {
        return $this->state(fn (array $attributes) => [
            'price'      => $this->faker->randomFloat(2, 500, 999),
            'cost_price' => $this->faker->randomFloat(2, 250, 500),
        ]);
    }

    /**
     * Create cheap products
     */
    public function cheap(): static
    {
        return $this->state(fn (array $attributes) => [
            'price'      => $this->faker->randomFloat(2, 1, 100),
            'cost_price' => $this->faker->randomFloat(2, 0.50, 50),
        ]);
    }
}
