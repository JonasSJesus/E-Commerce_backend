<?php
declare(strict_types=1);

namespace Database\Factories;

use App\Models\Product;
use Illuminate\Database\Eloquent\Factories\Factory;
use Illuminate\Support\Carbon;

class ProductFactory extends Factory
{
    protected $model = Product::class;

    public function definition(): array
    {
        return [
            'name'                => $this->faker->name(),
            'slug'                => $this->faker->slug(),
            'description'         => $this->faker->text(),
            'short_description'   => $this->faker->text(),
            'price'               => $this->faker->randomFloat(),
            'cost_price'          => $this->faker->randomFloat(),
            'stock_quantity'      => $this->faker->randomNumber(),
            'low_stock_threshold' => $this->faker->randomNumber(),
            'weight'              => $this->faker->randomFloat(),
            'active'              => $this->faker->boolean(),
            'featured'            => $this->faker->boolean(),
            'category_id'         => $this->faker->randomNumber(),
            'specifications'      => $this->faker->words(),
            'deleted_at'          => Carbon::now(),
            'created_at'          => Carbon::now(),
            'updated_at'          => Carbon::now(),
        ];
    }
}
