<?php
declare(strict_types=1);

namespace App\Repositories\User\Core;

use App\Exceptions\User\UserException;
use App\Models\User;
use App\Repositories\Base\BaseRepository;
use App\Repositories\User\Contracts\UserRepository;
use Illuminate\Database\Eloquent\ModelNotFoundException;
use Illuminate\Support\Collection;
use Illuminate\Support\Facades\Hash;

/**
 * @extends BaseRepository<User>
 */
class UserRepositoryCore extends BaseRepository implements UserRepository
{
    protected $modelClass = User::class;

    public function __construct(User $model)
    {
        $this->modelClass = $model;
    }

    public function createUser(array $user): User
    {
        if ($this->findByEmail($user['email'])) {
            throw UserException::emailAlreadyExists();
        }

        $query = $this->getQuery();
        return $query->create([
            'name'      => $user['name'],
            'email'     => $user['email'],
            'password'  => Hash::make($user['password']),
            'phone'     => $user['phone'] ?? null
        ]);
    }


    public function getUserById($id): User|null
    {
        $query = $this->getQuery();
        if ($user = $query->find($id)) {
            return $user;
        }

        return null;
    }

    public function getUsers(): Collection|null
    {
        $query = $this->getQuery();
        if ($user = $query->get()) {
            return $user;
        }

        return null;
    }

    public function updateUser(int $id, array $newProperties): User|null
    {
        $query = $this->getQuery();
        if ($user = $query->find($id)) {
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
        $query = $this->getQuery();
        if ($user = $query->find($id)) {
            return $user->deleteOrFail();
        }

        return false;
    }

    public function updateUserPwd(int $id, string $password): User
    {
        $query = $this->getQuery();
        $user = $query->find($id);

        if (!$user) {
            throw UserException::userNotFound();
        }

        $user->update([
            'password' => Hash::make($password),
        ]);

        return $user;
    }

    public function findByEmail(string $email): User|null
    {
        $query = $this->getQuery();
        $query->where('email', $email);
        $user = $query->get();

        if ($user) {
            return $user->first();
        }

        return null;
    }
}
