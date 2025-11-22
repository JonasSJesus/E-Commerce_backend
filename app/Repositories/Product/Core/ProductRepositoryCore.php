<?php
declare(strict_types=1);

namespace App\Repositories\Product\Core;

use App\Models\Product;
use App\Repositories\Base\BaseRepository;
use App\Repositories\Product\Contracts\ProductRepository;
use Illuminate\Support\Collection;

class ProductRepositoryCore extends BaseRepository implements ProductRepository
{
    protected $modelClass = Product::class;

    public function __construct(Product $model)
    {
        $this->modelClass = $model;
    }

    public function createProduct(array $product): Product
    {
        $query = $this->getQuery();

        return $query->create([
            'name'           => $product['name'],
            'slug'           => $product['slug'],
            'description'    => $product['description'],
            'price'          => $product['price'],
            'cost_price'     => $product['cost_price'],
            'stock_quantity' => $product['stock_quantity'],
            'category_id'    => $product['category_id'] ?? null,
        ]);
    }

    public function getProductById(int $id): Product|null
    {
        // TODO: Implement getProductById() method.
    }

    public function findByEmail(string $email): Product|null
    {
        // TODO: Implement findByEmail() method.
    }

    public function getProducts(): Collection|null
    {
        return $this->getQuery()->get();
    }

    public function updateProduct(int $id, array $newProperties): Product|null
    {
        // TODO: Implement updateProduct() method.
    }

    public function updateProductPwd(int $id, string $password): Product
    {
        // TODO: Implement updateProductPwd() method.
    }

    public function deleteProduct(int $id): bool
    {
        // TODO: Implement deleteProduct() method.
    }
}
