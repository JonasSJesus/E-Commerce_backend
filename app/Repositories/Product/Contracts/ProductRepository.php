<?php
declare(strict_types=1);

namespace App\Repositories\Product\Contracts;

use App\Models\Product;
use Illuminate\Support\Collection;

interface ProductRepository
{

    public function getProductById(int $id): Product;

    /** @return Collection|null */
    public function getProducts(): Collection|null;
}
