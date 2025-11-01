<?php
declare(strict_types=1);

namespace App\Http\Controllers\Authentication;

use App\Http\Requests\AuthFormRequest;
use App\Http\Requests\UserFormRequest;
use App\Services\AuthService;
use Illuminate\Http\JsonResponse;
use Illuminate\Routing\Controller;

class AuthController extends Controller
{
    private AuthService $authService;

    public function __construct(AuthService $authService)
    {
        $this->authService = $authService;
    }

    public function login(AuthFormRequest $request): JsonResponse
    {
        $validatedCredentials = $request->validated();

        $token = $this->authService->login($validatedCredentials);
        $response = $this->authService->respondWithToken($token);

        return response()->json($response);
    }

    public function register(UserFormRequest $request): JsonResponse
    {
        $credentials = $request->validated();

        try {
            $userData = $this->authService->registerUser($credentials);

            return response()->json($userData);
        } catch (\Exception $e) {
            return response()->json([
                "error" => "erro ao criar o usuario: {$e->getMessage()}"
            ], 400);
        }
    }

    public function me(): JsonResponse
    {
        return response()->json(auth()->user());
    }

    public function logout(): JsonResponse
    {
        $this->authService->logout();

        return response()->json(['message' => 'Deslogado com sucesso!']);
    }

    public function refresh(): JsonResponse
    {
        $response = $this->authService->refreshToken();

        return response()->json($response);
    }
}
