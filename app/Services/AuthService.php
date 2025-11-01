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
        $user = $this->userRepository->createUser($credentials);

        $userCreated = [
            'id' => $user->id,
            'name' => $user->name,
            'email' => $user->email,
            'phone' => $user->phone,
        ];

        $token = Auth::login($user);
        $authCredentials = [
            'access_token' => $token,
            'token_type' => 'Bearer',
            'expires_in' => Auth::factory()->getTTL() * 60
        ];

        $response = collect($userCreated)->merge($authCredentials);

        return $response;
    }

    public function logout(): void
    {
        Auth::logout();
    }

    public function refreshToken(): JsonResponse
    {
        $newToken = Auth::refresh();

        return $this->respondWithToken($newToken);
    }

    public function respondWithToken($token): JsonResponse
    {
        return response()->json([
            'access_token' => $token,
            'token_type' => 'Bearer',
            'expires_in' => Auth::factory()->getTTL() * 60
        ]);
    }
}
