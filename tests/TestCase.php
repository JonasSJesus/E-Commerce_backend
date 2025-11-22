<?php
declare(strict_types=1);

namespace Tests;

use App\Models\JwtSession;
use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\TestCase as BaseTestCase;
use Tymon\JWTAuth\Facades\JWTAuth;

abstract class TestCase extends BaseTestCase
{
    use RefreshDatabase;

    protected function authUser(?User $user = null): TestCase
    {
        if (!$user){
            $user = User::factory()->createOne();
        }
        $token = JWTAuth::fromUser($user);

        // Obter o payload do token para extrair o JTI
        $payload = JWTAuth::setToken($token)->getPayload();
        $tokenId = $payload->get('jti');

        // Criar a sessão JWT no banco de dados
        JwtSession::factory()->create([
            'user_id'       => $user->id,
            'token_id'      => $tokenId,
            'ip_address'    => '127.0.0.1', // IP padrão para testes
        ]);

        return $this->withHeaders([
            'Authorization' => 'Bearer '.$token,
            'Accept'        => 'Application/json'
        ]);
    }
}
