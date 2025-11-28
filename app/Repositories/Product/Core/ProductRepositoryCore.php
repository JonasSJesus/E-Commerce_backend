<?php
declare(strict_types=1);

namespace App\Repositories\Product\Core;

use App\Exceptions\Model\ResourceException;
use App\Exceptions\ProductException;
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

    /**
     * @throws ResourceException
     */
    public function getProductById(int $id): Product
    {
        $product = $this->getQuery()->find($id);

        if (!$product) {
            throw ResourceException::notFound("Produto");
        }

        return $product;
    }

    public function getProducts(): Collection|null
    {
        return $this->getQuery()->get();
    }

    public function updateProduct(int $id, array $newProperties): Product|null
    {
        $product = $this->getProductById($id);

        return $product->update($newProperties);
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
