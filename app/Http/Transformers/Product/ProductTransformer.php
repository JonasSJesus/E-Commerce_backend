<?php
declare(strict_types=1);

namespace App\Http\Transformers\Product;

use App\Models\Product;
use League\Fractal\TransformerAbstract;

class ProductTransformer extends TransformerAbstract
{
    public function transform(Product $product): array
    {
        return [
            'id'                  => $product->id,
            'name'                => $product->name,
            'slug'                => $product->slug,
            'description'         => $product->description,
            'price'               => $product->price,
            'cost_price'          => $product->cost_price,
            'stock_quantity'      => $product->stock_quantity,
            'low_stock_threshold' => $product->low_stock_threshold,
            'active'              => $product->active,
            'category_id'         => $product->category_id,
        ];
    }
}
