<?php
declare(strict_types=1);

namespace App\Http\Controllers\Product;

use App\Exceptions\Model\ResourceException;
use App\Http\Controllers\Base\ApiController;
use App\Http\Requests\ProductFormRequest;
use App\Http\Transformers\Product\ProductTransformer;
use App\Repositories\Product\Contracts\ProductRepository;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;

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
     * Display the specified resource.
     */
    public function show(int $id)
    {
        try {
            $product = $this->productRepository->getProductById($id);

            return $this->responseItem($product, new ProductTransformer);
        } catch (ResourceException $e) {
            return $this->responseError($e->getMessage(), Response::HTTP_NOT_FOUND);
        }
    }
}
