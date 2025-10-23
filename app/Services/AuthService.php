<?php

declare(strict_types=1);

namespace App\Services;

use Illuminate\Auth\AuthenticationException;
use Illuminate\Support\Facades\Auth;

class AuthService
{
    public function login(array $credentials): bool|string
    {
        if (!$token = Auth::attempt($credentials)) {
            throw new AuthenticationException('Credenciais invalidas');
        }

        return $token;
    }
}
