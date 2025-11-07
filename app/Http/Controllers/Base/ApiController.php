<?php
declare(strict_types=1);

namespace App\Http\Controllers\Base;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Http\JsonResponse;
use Illuminate\Support\Collection as LaravelCollection;
use League\Fractal\Manager;
use League\Fractal\Resource\Collection as FractalCollection;
use League\Fractal\Resource\Item;
use League\Fractal\TransformerAbstract;

abstract class ApiController
{
    public function responseCollection(array|LaravelCollection $data, TransformerAbstract $transformer, array $includes = []): JsonResponse
    {
        $fractal = new Manager();
        $fractal->parseIncludes($includes);
        $resource = new FractalCollection($data, $transformer);
        $response = $fractal->createData($resource)->toArray();

        return response()->json($response);
    }

    public function responseItem(array|LaravelCollection|Model $data, TransformerAbstract $transformer, array $includes = []): JsonResponse
    {
        $fractal = new Manager();
        $fractal->parseIncludes($includes);
        $resource = new Item($data, $transformer);
        $response = $fractal->createData($resource)->toArray();

        return response()->json($response);
    }
}
