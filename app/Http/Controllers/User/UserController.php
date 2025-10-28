<?php
declare(strict_types=1);

namespace App\Http\Controllers\User;

use App\Http\Requests\UserFormRequest;
use App\Repositories\User\Contracts\UserRepository;
use Illuminate\Http\JsonResponse;

class UserController
{
    private UserRepository $repository;

    /**
     * @param UserRepository $repository
     */
    public function __construct(UserRepository $repository)
    {
        $this->repository = $repository;
    }

    /**
     * Display a listing of the resource.
     */
    public function index(): JsonResponse
    {
        $user = $this->repository->getUsers();

        return response()->json(["message" => $user]);
    }

    /**
     * Display the specified resource.
     */
    public function show(string $id): JsonResponse
    {
        if ($user = $this->repository->getUserById($id)) {
            return response()->json([
                "message" => [
                    "user" => $user
                ]
            ]);
        }

        return response()->json([
            "error" => "Usuario nao encontrado"
        ]);

    }

    /**
     * Update the specified resource in storage.
     */
    public function update(UserFormRequest $request, int $id): JsonResponse
    {
        $credentials = $request->validated();

        try {
            $user = $this->repository->updateUser($id, $credentials);

            return response()->json([
                "message" => "Usuário {$user->name} (id: {$user->id}) atualizado com sucesso!"
            ]);
        } catch (\Exception $e) {
            return response()->json([
                "error" => "erro ao atualizar o usuario: {$e->getMessage()}"
            ]);
        }
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id): JsonResponse
    {
        if ($this->repository->deleteUser($id)){
            return response()->json([
                "message" => "Usuario deletado com sucesso!"
            ]);
        }

        return response()->json(["error" => "nao foi possivel excluir este usuario"]);
    }
}
