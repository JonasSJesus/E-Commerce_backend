<?php

namespace App\Repositories;

use Illuminate\Database\Eloquent\Model;

abstract class BaseRepository
{
    protected $modelClass;

    public function __construct(Model $model)
    {
        $this->modelClass = $model;
    }

    public function getQuery()
    {
        return $this->modelClass->newQuery();
    }
}
