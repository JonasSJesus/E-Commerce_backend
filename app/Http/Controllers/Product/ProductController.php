<?php
declare(strict_types=1);

namespace App\Http\Controllers\Product;

use App\Http\Controllers\Base\ApiController;
use App\Http\Requests\ProductFormRequest;
use App\Http\Transformers\Product\ProductTransformer;
use App\Repositories\Product\Contracts\ProductRepository;
use Illuminate\Http\Request;

class ProductController extends ApiController
{
    private ProductRepository $productRepository;

    public function __construct(ProductRepository $productRepository)
    {
        $this->productRepository = $productRepository;
    }

    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        try {
            $products = $this->productRepository->getProducts();

            return $this->responseCollection($products, new ProductTransformer);
        } catch (\Exception $e) {
            return $this->responseError($e->getMessage());
        }
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(ProductFormRequest $request)
    {
        $validatedData = $request->validated();

        try {
            $product = $this->productRepository->createProduct($validatedData);

            return $this->responseCreated(
                modelCreated: $product,
                transformer:  new ProductTransformer,
                resourceName: 'Produto'
            );
        } catch (\Exception $e) {
            return $this->responseError($e->getMessage());
        }
    }

    /**
     * Display the specified resource.
     */
    public function show(string $id)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, string $id)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        //
    }
}
