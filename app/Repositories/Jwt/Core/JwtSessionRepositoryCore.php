<?php
declare(strict_types=1);

namespace App\Repositories\Jwt\Core;

use App\Models\JwtSession;
use App\Repositories\Base\BaseRepository;
use App\Repositories\Jwt\Contracts\JwtSessionRepository;
use Illuminate\Database\Eloquent\Builder;

class JwtSessionRepositoryCore extends BaseRepository implements JwtSessionRepository
{
    protected $modelClass;

    private Builder $query;

    public function __construct(JwtSession $modelClass)
    {
        $this->modelClass = $modelClass;
        $this->query = $this->getQuery();
    }

    public function createSession(array $session): bool
    {
        if ($this->query->create($session)) {
            return true;
        }

        return false;
    }

    public function getSessionById(int $id): JwtSession|null
    {
        return $this->query->find($id);
    }

    public function getSessionByTokenId(string $tokenId): JwtSession|null
    {
        return $this->query->where('token_id', $tokenId)->first();
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
