<?php

declare(strict_types=1);

namespace App\Services;

use App\Repositories\Jwt\Contracts\JwtSessionRepository;
use App\Repositories\User\Contracts\UserRepository;
use Illuminate\Auth\AuthenticationException;
use Illuminate\Http\Request;
use Illuminate\Support\Collection;
use Illuminate\Support\Facades\Auth;
use Illuminate\Validation\Rules\Password;

class AuthService
{
    private UserRepository $userRepository;

    private JwtSessionRepository $sessionRepository;

    public function __construct(UserRepository $userRepository, JwtSessionRepository $sessionRepository)
    {
        $this->userRepository = $userRepository;
        $this->sessionRepository = $sessionRepository;
    }

    /**
     * @param array $credentials
     * @param Request $request
     * @return array
     * @throws AuthenticationException
     */
    public function login(array $credentials, Request $request): array
    {
        if (!$token = Auth::attempt($credentials)) {
            throw new AuthenticationException('Credenciais invalidas');
        }

        $this->saveSession($request);

        return $this->prepareToken($token);
    }

    public function registerUser(array $credentials): Collection
    {
        $user = $this->userRepository->createUser($credentials);

        $userCreated = [
            'id' => $user->id,
            'name' => $user->name,
            'email' => $user->email,
            'phone' => $user->phone ?? null,
        ];

        $token = Auth::login($user);
        $authCredentials = $this->prepareToken($token);

        return collect($userCreated)->merge($authCredentials);
    }

    public function logout(): void
    {
        $tokenId = Auth::payload()->get('jti');

        $this->sessionRepository->deleteSession($tokenId);

        Auth::logout();
    }

    public function refreshToken(): array
    {
        $newToken = Auth::refresh();

        return $this->prepareToken($newToken);
    }

    private function prepareToken($token): array
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

    /**
     * @param Request $request
     * @return void
     */
    public function saveSession(Request $request): void
    {
        $user = auth()->user();
        $payload = Auth::payload();

        $this->sessionRepository->createSession([
            'user_id' => $user->id,
            'token_id' => $payload->get('jti'),
            'ip_address' => $request->ip(),
            'user_agent' => $request->userAgent(),
            'last_activity' => now(),
            'expires_at' => date('d/m/Y H:i:s', $payload->get('exp'))
        ]);
    }
}
