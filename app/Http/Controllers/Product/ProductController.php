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
    public function show(int $id)
    {
        try {
            $product = $this->productRepository->getProductById($id);

            return $this->responseItem($product, new ProductTransformer);
        } catch (ResourceException $e) {
            return $this->responseError($e->getMessage(), Response::HTTP_NOT_FOUND);
        }
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, int $id)
    {
        try {
            $product = $this->productRepository->getProductById($id);
            $product->update($request->all());

            return $this->responseItem($product, new ProductTransformer);
        } catch (ResourceException $e) {
            return $this->responseError($e->getMessage(), Response::HTTP_NOT_FOUND);
        }
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(int $id)
    {
        try {
            $this->productRepository->deleteProduct($id);

            return $this->responseOk("Produto deletado com sucesso", Response::HTTP_NO_CONTENT);
        } catch (ResourceException $e) {
            return $this->responseError($e->getMessage(), Response::HTTP_NOT_FOUND);
        }
    }
}
