<?php

namespace Tests\Feature\User;

use App\Models\User;
use Tests\TestCase;

class HttpUserTest extends TestCase // Todo: Rotas de usuario devem ser acessiveis somente para o usuario logado
{
    public function test_user_can_view_user_by_id()
    {
        $user = User::factory()->create();

        $response = $this->authUser($user)
            ->getJson(route('api.v1.private.user.show', $user->id));

        $response->assertOk();
        $response->assertJsonFragment([
            'email' => $user->email,
            'nome'  => $user->name,
            'ativo' => $user->active,
        ]);
    }

    public function test_user_can_update_profile()
    {
        $user = User::factory()->create();
        $payload = [
            'name'  => 'Updated Name',
            'email' => 'updated@example.com',
            'phone' => '(51) 9 9999-9999'
        ];

        $response = $this->authUser($user)
            ->putJson(route('api.v1.private.user.update', $user->id), $payload);

        $response->assertOk();
        $response->assertJsonPath('message', "Usuario {$payload['name']} (id: {$user->id}) atualizado com sucesso!");
        $this->assertDatabaseHas('users', [
            'id' => $user->id,
            'name' => 'Updated Name',
            'email' => 'updated@example.com',
        ]);
    }

    public function test_user_can_delete_account()
    {
        $user = User::factory()->create();

        $response = $this->authUser($user)
            ->deleteJson(route('api.v1.private.user.destroy', $user->id));

        $response->assertOk();
        $response->assertJsonPath('message', 'Usuario deletado com sucesso!');
        $this->assertSoftDeleted('users', [
            'id' => $user->id
        ]);
    }
}
