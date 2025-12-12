<?php
declare(strict_types=1);

namespace Tests\Feature\Product;

use App\Models\Category;
use App\Models\Product;
use Tests\TestCase;

class HttpProductTest extends TestCase
{
    public function test_user_can_view_all_products()
    {
        // Arrange
        $products = Product::factory()->count(5)->create();
        $firstProduct = $products->first();

        // Act
        $response = $this->authUser()
            ->getJson(route('api.v1.products.index'));

        // Assert
        $response->assertOk();
        $response->assertJsonCount(5, 'data');
        $response->assertJsonFragment([
            'id'   => $firstProduct->id,
            'name' => $firstProduct->name,
            'slug' => $firstProduct->slug,
        ]);
        $response->assertJsonStructure([
            'data' => [
                '*' => [
                    'id',
                    'name',
                    'slug',
                    'description',
                    'price',
                    'cost_price',
                    'stock_quantity',
                    'low_stock_threshold',
                    'active',
                    'category_id',
                ]
            ]
        ]);
    }

    public function test_user_can_view_single_product()
    {
        // Arrange
        $product = Product::factory()->create();

        // Act
        $response = $this->authUser()
            ->getJson(route('api.v1.products.show', $product->id));

        // Assert
        $response->assertOk();
        $response->assertJsonFragment([
            'id'   => $product->id,
            'name' => $product->name,
            'slug' => $product->slug,
            'description' => $product->description,
        ]);
        $response->assertJsonStructure([
            'data' => [
                'id',
                'name',
                'slug',
                'description',
                'price',
                'cost_price',
                'stock_quantity',
                'low_stock_threshold',
                'active',
                'category_id',
            ]
        ]);
    }

    public function test_not_found_error_for_product_that_doesnt_exists()
    {
        $response = $this->authUser()
            ->getJson(route('api.v1.products.show', 1));

        $response->assertNotFound();
        $response->assertJsonPath('error', 'Não foi possível encontrar nenhum Produto');
    }
}
