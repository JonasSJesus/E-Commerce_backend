<?php

declare(strict_types=1);

namespace App\Services;

use App\Repositories\User\Contracts\UserRepository;
use Illuminate\Auth\AuthenticationException;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Validation\Rules\Password;

class AuthService
{

    private UserRepository $userRepository;

    public function __construct(UserRepository $userRepository)
    {
        $this->userRepository = $userRepository;
    }

    /**
     * @param array $credentials
     * @return bool|string
     * @throws AuthenticationException
     */
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

        return collect($userCreated)->merge($authCredentials);
    }

    public function logout(): void
    {
        Auth::logout();
    }

    public function refreshToken(): array
    {
        $newToken = Auth::refresh();

        return $this->respondWithToken($newToken);
    }

    public function respondWithToken($token): array
    {
        return [
            'access_token' => $token,
            'token_type' => 'Bearer',
            'expires_in' => Auth::factory()->getTTL() * 60
        ];
    }

    public function updateUserPwd(Request $request, int $userId): array
    {
        $validatedData = $request->validate([
            'password' => ['required', Password::min(8)
                ->mixedCase()
                ->numbers()
                ->symbols()
                ->letters()],
        ]);

        $user = $this->userRepository->updateUserPwd($userId, $validatedData['password']);

        return $user->toArray();
    }
}
