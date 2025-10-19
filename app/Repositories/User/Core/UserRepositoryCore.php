<?php

namespace App\Repositories\User\Core;

use App\Models\User;
use App\Repositories\BaseRepository;
use App\Repositories\User\Contracts\UserRepository;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Collection;

/**
 * @extends BaseRepository<User>
 */
class UserRepositoryCore extends BaseRepository implements UserRepository
{
    protected $modelClass;

    private Builder $query;

    public function __construct(User $model)
    {
        parent::__construct($model);
        $this->query = $this->getQuery();
    }

    public function createUser(array $user): User
    {
        return $this->query->create([
            'name'      => $user['name'],
            'email'     => $user['email'],
            'password'  => $user['password'],
            'role'      => "customer",
            'phone'     => $user['phone']
        ]);
    }


    public function getUserById($id): User|null
    {
        if ($user = $this->query->find($id)) {
            return $user;
        }

        return null;
    }

    public function getUsers(): Collection|null
    {
        if ($user = $this->query->get()) {
            return $user;
        }

        return null;
    }

    public function updateUser(int $id, array $newProperties): User|null
    {
        if ($user = $this->query->find($id)) {
            $user->update([
                'name'      => $newProperties['name'],
                'email'     => $newProperties['email'],
                'password'  => $newProperties['password'],
                'phone'     => $newProperties['phone']
            ]);

            return $user;
        }

        return null;
    }

    public function deleteUser($id): bool
    {
        if ($user = $this->query->find($id)) {
            return $user->deleteOrFail();
        }

        return false;
    }
}
