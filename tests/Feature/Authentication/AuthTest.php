<?php

namespace Tests\Feature\Authentication;

use App\Models\JwtSession;
use App\Models\User;
use Illuminate\Testing\TestResponse;
use Tests\TestCase;

class AuthTest extends TestCase
{
    public function testUserCanRegister()
    {
        // Arrange
        $input = [
            "name"      => fake()->name(),
            "email"     => fake()->email(),
            "password"  => "Fake@123",
            "phone"     => "(51) 9 1234-4321"
        ];
        // Act
        $response = $this->post(route('api.v1.auth.register'), $input);

        // Assert
        $response->assertCreated();
        $this->assertDatabaseHas('users', [
            "name"      => $input['name'],
            "email"     => $input['email'],
            "phone"     => "(51) 9 1234-4321"
        ]);
    }

    public function testUserShouldNotUpdateAnotherUserPassword()
    {
        // Arrange
        $userA = User::factory()->create();

        // Act
        $responseLogin = $this->makeLogin();
        $token = json_decode($responseLogin->content())->access_token;

        $response = $this->put(
            uri:     route('api.v1.auth.private.update.password', $userA->id),
            data:    [
                "password" => "ShouldNotUpdate"
            ],
            headers: [
                'Authorization' => 'Bearer ' . $token,
                'Accept'        => 'application/json'
        ]);

        // Assert
        $response->assertForbidden();
    }

    public function testRefreshTokenShouldDeleteOldSession()
    {
        // Arrange
        $responseLogin = $this->makeLogin();
        $token = json_decode($responseLogin->content())->access_token;

        $oldJti = auth()->payload()->get('jti');
        $this->assertDatabaseHas('jwt_sessions', [
            'token_id' => $oldJti
        ]);

        // Act
        $response = $this->post(
            uri:     route('api.v1.auth.private.refresh'),
            headers: [
                'Authorization' => 'Bearer ' . $token,
                'Accept'        => 'application/json'
        ]);

        $newJti = auth()->payload()->get('jti');

        // Assert
        $response->assertOk();
        $this->assertNotEquals($oldJti, $newJti);
        $this->assertDatabaseMissing('jwt_sessions', [
            'token_id' => $oldJti
        ]);
        $this->assertDatabaseHas('jwt_sessions', [
            'token_id' => $newJti
        ]);
    }

    public function testUserCanLogin()
    {
        // Arrange & Act
        $response = $this->makeLogin();
        $session = JwtSession::first();

        // Assert
        $response->assertOk();
        $this->assertDatabaseCount('jwt_sessions', 1);

        $this->assertNotNull($session);
        $this->assertTrue($session->last_activity->isToday());
    }

    public function testUserCannotLoginWithUnvalidCredentials()
    {
        // Arrange
        $user = User::factory()->create();
        $payload = [
            'email'    => $user->email,
            'password' => 'SenhaErrada123'
        ];

        // Act
        $response = $this->post(route('api.v1.auth.login'), $payload);

        // Assert
        $response->assertUnauthorized();
    }

    public function testUserCanLogout()
    {
        // Arrange
        $response = $this->makeLogin();
        $token = json_decode($response->content())->access_token;

        // Act
        $response = $this->delete(route('api.v1.auth.private.logout'), [
            'Authorization' => 'Bearer ' . $token,
            'Accept'        => 'application/json'
        ]);

        // Assert
        $response->assertOk();
    }

    public function testUserCannotAccessPrivateRoutes()
    {
        // Act
        $responseResource = $this->get(route('api.v1.private.user.index'));
        $responseAuthPrivate = $this->post(route('api.v1.auth.private.refresh'));

        // Assert
        $responseResource->assertUnauthorized();
        $responseAuthPrivate->assertUnauthorized();
    }

    private function makeLogin(): TestResponse
    {
        $user = User::factory()->create();
        $payload = [
            'email' => $user->email,
            'password' => 'secret'
        ];

        return $this->postJson(route('api.v1.auth.login'), $payload);
    }
}
