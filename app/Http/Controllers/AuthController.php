<?php
declare(strict_types=1);

namespace App\Http\Controllers;

use App\Http\Requests\AuthFormRequest;
use App\Services\AuthService;
use Illuminate\Routing\Controller;
use Illuminate\Support\Facades\Auth;

class AuthController extends Controller
{
    private AuthService $authService;

    /**
     * @param AuthService $authServicel
     */
    public function __construct(AuthService $authServicel)
    {
        $this->authService = $authServicel;
    }

    public function login(AuthFormRequest $request)
    {
        $validatedCredentials = $request->validated();

        $token = $this->authService->login($validatedCredentials);

        return $this->respondWithToken($token);
    }

    public function me()
    {
        return response()->json(auth()->user());
    }

    public function logout()
    {
        Auth::logout();

        return response()->json(['message' => 'Deslogado com sucesso!']);
    }

    public function refresh()
    {
        return $this->respondWithToken(Auth::guard('api')->refresh());
    }


    protected function respondWithToken($token)
    {
        return response()->json([
            'access_token' => $token,
            'token_type' => 'bearer',
            'expires_in' => Auth::factory()->getTTL() * 60
        ]);
    }
}
