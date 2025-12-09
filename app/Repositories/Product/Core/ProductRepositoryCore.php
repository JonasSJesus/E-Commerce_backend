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
}
