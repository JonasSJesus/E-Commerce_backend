<?php
declare(strict_types=1);

namespace App\Repositories\User\Core;

use App\Models\User;
use App\Repositories\Base\BaseRepository;
use App\Repositories\User\Contracts\UserRepository;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Support\Collection;
use Illuminate\Support\Facades\Hash;

/**
 * @extends BaseRepository<User>
 */
class UserRepositoryCore extends BaseRepository implements UserRepository
{
    protected $modelClass = User::class;

    private Builder $query;

    public function __construct(User $model)
    {
        $this->modelClass = $model;
        $this->query      = $this->getQuery();
    }

    public function createUser(array $user): User
    {
        return $this->query->create([
            'name'      => $user['name'],
            'email'     => $user['email'],
            'password'  => Hash::make($user['password']),
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

    public function updateUserPwd(int $id, string $password): false|User
    {
        $user = $this->query->findOrFail($id);

        $user->update([
            'password' => Hash::make($password),
        ]);

        return $user;
    }
}
