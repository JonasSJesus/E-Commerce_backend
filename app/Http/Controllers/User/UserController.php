<?php
declare(strict_types=1);

namespace App\Http\Controllers\User;

use App\Http\Controllers\Base\ApiController;
use App\Http\Requests\UserFormRequest;
use App\Http\Transformers\UserTransformer;
use App\Repositories\User\Contracts\UserRepository;
use Illuminate\Http\JsonResponse;
use Symfony\Component\HttpKernel\Exception\NotFoundHttpException;

class UserController extends ApiController // Todo: esta classe deve gerenciar somente a conta do user logado, em vez de todos os usuarios
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
     * Display the specified resource.
     */
    public function show(string $id): JsonResponse
    {
        $user = $this->repository->getUserById($id);

        if (!$user) {
            throw new NotFoundHttpException("Nenhum Recurso encontrado");
        }

        return $this->responseItem($user, new UserTransformer);
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
                "message" => "Usuario {$user->name} (id: {$user->id}) atualizado com sucesso!"
            ]);
        } catch (\Exception $e) {
            return response()->json([
                "error" => "erro ao atualizar o usuario: {$e->getMessage()}"
            ], 400);
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

        return response()->json(["error" => "nao foi possivel excluir este usuario"], 400);
    }
}
