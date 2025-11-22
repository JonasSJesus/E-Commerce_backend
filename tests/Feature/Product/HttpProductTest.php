<?php
declare(strict_types=1);

namespace Tests\Feature\Product;

use App\Models\Category;
use App\Models\Product;
use Tests\TestCase;

class HttpProductTest extends TestCase
{
    // Todo: testar permissao de admin para cadastrar produtos
    public function test_user_can_register_products()
    {
        // Arrange
        $category = Category::factory()->create();
        $payload = [
            'name'           => 'Produto Teste',
            'slug'           => 'produto-teste-1',
            'description'    => 'Descrição do produto',
            'price'          => '100.50',
            'cost_price'     => '50.00',
            'stock_quantity' => 30,
            'category_id'    => $category->id,
        ];

        // Act
        $response = $this->authUser()
            ->postJson(route('api.v1.private.products.store'), $payload);

        // Assert
        $response->assertCreated();
        $response->assertJsonPath('message', 'Produto criado com sucesso');
        $response->assertJsonFragment([
            'name'           => $payload['name'],
            'slug'           => $payload['slug'],
            'description'    => $payload['description'],
            'price'          => '100.50',
            'cost_price'     => '50.00',
            'stock_quantity' => $payload['stock_quantity'],
            'category_id'    => $payload['category_id'],
        ]);
        $this->assertDatabaseHas('products', [
            'name'       => 'Produto Teste',
            'price'      => 100.50,
            'cost_price' => 50.00
        ]);    }

    public function test_user_can_view_all_products()
    {
        // Arrange
        $products = Product::factory()->count(5)->create();
        $firstProduct = $products->first();

        // Act
        $response = $this->authUser()
            ->getJson(route('api.v1.private.products.index'));

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
}
