<?php
declare(strict_types=1);

namespace App\Repositories\Base;

abstract class BaseRepository
{
    protected $modelClass;

    public function getQuery()
    {
        return $this->modelClass->newQuery();
    }
}
