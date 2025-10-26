<?php

declare(strict_types=1);

namespace App\Services;

use App\Repositories\User\Contracts\UserRepository;
use Illuminate\Auth\AuthenticationException;
use Illuminate\Http\JsonResponse;
use Illuminate\Support\Facades\Auth;

class AuthService
{

    private UserRepository $userRepository;

    public function __construct(UserRepository $userRepository)
    {
        $this->userRepository = $userRepository;
    }


    public function login(array $credentials): bool|string
    {
        if (!$token = Auth::attempt($credentials)) {
            throw new AuthenticationException('Credenciais invalidas');
        }

        return $token;
    }

    public function registerUser(array $credentials)
    {
        return $this->userRepository->createUser($credentials);
    }

    public function logout()
    {
        return Auth::logout();
    }

    public function refreshToken()
    {
        $newToken = Auth::refresh();

        return $this->respondWithToken($newToken);
    }

    public function respondWithToken($token): JsonResponse
    {
        return response()->json([
            'access_token' => $token,
            'token_type' => 'bearer',
            'expires_in' => Auth::factory()->getTTL() * 60
        ]);
    }
}
