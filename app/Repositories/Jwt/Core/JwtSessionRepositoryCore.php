<?php
declare(strict_types=1);

namespace App\Repositories\Jwt\Core;

use App\Models\JwtSession;
use App\Repositories\Base\BaseRepository;
use App\Repositories\Jwt\Contracts\JwtSessionRepository;

class JwtSessionRepositoryCore extends BaseRepository implements JwtSessionRepository
{
    protected $modelClass;

    public function __construct(JwtSession $modelClass)
    {
        $this->modelClass = $modelClass;
    }

    public function createSession(array $session): bool
    {
        $query = $this->getQuery();

        return (bool) $query->create($session);
    }

    public function getSessionById(int $id): JwtSession|null
    {
        $query = $this->getQuery();
        return $query->find($id);
    }

    public function getSessionByTokenId(string $tokenId): JwtSession|null
    {
        $query = $this->getQuery();
        return $query->where('token_id', $tokenId)->first();
    }

    public function deleteSession(string $tokenId): bool|null
    {
        $session = $this->getSessionByTokenId($tokenId);

        if ($session) {
            return $session->delete();
        }

        return false;
    }
}
