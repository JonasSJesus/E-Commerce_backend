<?php
declare(strict_types=1);

namespace App\Repositories\Jwt\Contracts;

use App\Models\JwtSession;

interface JwtSessionRepository
{
    public function createSession(array $session): bool;

    public function getSessionById(int $id): JwtSession|null;

    public function getSessionByTokenId(string $tokenId): JwtSession|null;

    public function deleteSession(string $tokenId): bool|null;
}
