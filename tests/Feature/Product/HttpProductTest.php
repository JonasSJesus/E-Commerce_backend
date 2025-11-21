<?php
declare(strict_types=1);

namespace Tests\Feature\Product;

use App\Models\Category;
use Tests\TestCase;

class HttpProductTest extends TestCase
{
    public function test_admin_can_register_products()
    {
        $category = Category::factory()->create();

        $payload = [
            'name'           => 'Produto Teste',
            'slug'           => 'produto-teste-1',
            'description'    => 'Descrição do produto',
            'price'          => 100.50,
            'cost_price'     => 50.00,
            'stock_quantity' => 30,
            'category_id'    => $category->id,
        ];

        $response = $this->authUser()
            ->postJson(route('api.v1.private.products.store'), $payload);

        $response->assertCreated();
        $this->assertDatabaseHas('products', ['name' => 'Produto Teste']);
    }
}
