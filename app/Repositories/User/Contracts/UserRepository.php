<?php
declare(strict_types=1);

namespace App\Repositories\User\Contracts;

use App\Models\User;
use Illuminate\Support\Collection;

interface UserRepository
{
    public function createUser(array $user);

    public function getUserById($id): User|null;

    /** @return Collection|null */
    public function getUsers(): Collection|null;

    public function updateUser(int $id, array $newProperties): User|null;

    public function deleteUser($id): bool;
}
