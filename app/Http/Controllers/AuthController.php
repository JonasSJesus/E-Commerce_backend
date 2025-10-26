<?php
declare(strict_types=1);

namespace App\Http\Controllers;

use App\Http\Requests\AuthFormRequest;
use App\Http\Requests\UserFormRequest;
use App\Services\AuthService;
use Illuminate\Http\JsonResponse;
use Illuminate\Routing\Controller;

class AuthController extends Controller
{
    private AuthService $authService;

    /**
     * @param AuthService $authService
     */
    public function __construct(AuthService $authService)
    {
        $this->authService = $authService;
    }

    public function login(AuthFormRequest $request): JsonResponse
    {
        $validatedCredentials = $request->validated();

        $token = $this->authService->login($validatedCredentials);

        return $this->authService->respondWithToken($token);
    }

    public function register(UserFormRequest $request)
    {
        $credentials = $request->validated();

        try {
            $user = $this->authService->registerUser($credentials);

            return response()->json([
                "message" => "Usuário criado com sucesso!",
                "access_token"   => "12903aklsmdi021nsd0f1nboijner", // Todo: Implementar token no retorno
                "user"    => [
                    "id"     => $user->id,
                    "name"   => $user->name,
                    "email"  => $user->email,
                    "phone"  => $user->phone,
                ]
            ]);
        } catch (\Exception $e) {
            return response()->json([
                "error" => "erro ao criar o usuario: {$e->getMessage()}"
            ]);
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
        return $this->authService->refreshToken();
    }
}
