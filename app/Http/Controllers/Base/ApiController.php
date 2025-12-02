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
use Symfony\Component\HttpFoundation\Response;

abstract class ApiController
{
    protected function responseCollection(
        array|LaravelCollection $data,
        TransformerAbstract     $transformer,
        array                   $includes = [],
        int                     $statusCode = 200,
        string                  $message = '',
    ): JsonResponse
    {
        $fractal = new Manager();
        $fractal->parseIncludes($includes);
        $resource = new FractalCollection($data, $transformer);
        $response = $fractal->createData($resource)->toArray();

        $responseJson = $response;

        if ($message) {
            $responseJson['message'] = $message;
        }

        return response()->json($responseJson, $statusCode);
    }

    protected function responseItem(
        array|LaravelCollection|Model $data,
        TransformerAbstract           $transformer,
        array                         $includes = [],
        int                           $statusCode = 200,
        string                        $message = '',
    ): JsonResponse
    {
        $fractal = new Manager();
        $fractal->parseIncludes($includes);
        $resource = new Item($data, $transformer);
        $response = $fractal->createData($resource)->toArray();

        $responseJson = $response;

        if ($message) {
            $responseJson['message'] = $message;
        }

        return response()->json($responseJson, $statusCode);
    }

    protected function responseCreated(
        Model               $modelCreated,
        TransformerAbstract $transformer,
        ?string             $resourceName = null,
        array               $includes = []
    ): JsonResponse
    {
        $modelName = (new \ReflectionClass($modelCreated)->getShortName());

        if (!$resourceName) {
            $resourceName = $modelName;
        }

        $message = "{$resourceName} criado com sucesso";

        return $this->responseItem(
            data:        $modelCreated,
            transformer: $transformer,
            includes:    $includes,
            statusCode:  Response::HTTP_CREATED,
            message:     $message);
    }

    protected function responseOk(?string $message = null, ?int $statusCode = null): JsonResponse
    {
        return response()->json($message ?? [], $statusCode ?? Response::HTTP_OK);
    }

    protected function responseError(string $message, int $statusCode = 400): JsonResponse
    {
        $message = [
            'error' => $message
        ];

        return response()->json($message, $statusCode);
    }
}
