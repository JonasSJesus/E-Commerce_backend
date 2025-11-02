<?php

namespace Tests\Feature\Authentication;

use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Testing\TestResponse;
use Tests\TestCase;

class AuthTest extends TestCase
{
    use RefreshDatabase;

    public function testUserCanRegister()
    {
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

    public function testUserCanLogin()
    {
        // Prepare
        $response = $this->makeLogin();

        // Assert
        $response->assertOk();
        $this->assertDatabaseHas('jwt_sessions', [
            'last_activity' => now()
        ]);
    }

    public function testUserCannotLoginWithUnvalidCredentials()
    {
        // Prepare
        $user = User::factory()->create();
        $payload = [
            'email' => $user->email,
            'password' => 'SenhaErrada123'
        ];

        // Act
        $response = $this->post(route('api.v1.auth.login'), $payload);

        // Assert
        $response->assertUnauthorized();
    }

    public function testUserCanLogout()
    {
        // Prepare
        $response = $this->makeLogin();
        $token = json_decode($response->content())->access_token;

        // Act
        $response = $this->delete(route('api.v1.auth.logout'), [
            'Authorization' => 'Bearer ' . $token,
            'Accept' => 'application/json'
        ]);

        // Assert
        $response->assertOk();
    }

    public function testUserCannotAccessPrivateRoutes()
    {
        // Act
        $response = $this->get(route('api.v1.private.user.index'));

        // Assert
        $response->assertUnauthorized();
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
