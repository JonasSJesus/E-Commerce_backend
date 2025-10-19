<?php

namespace App\Providers;

use App\Repositories\User\Contracts\UserRepository;
use App\Repositories\User\Core\UserRepositoryCore;
use Illuminate\Support\ServiceProvider;

class RepositoryServiceProvider extends ServiceProvider
{
    public array $bindings = [
        UserRepository::class => UserRepositoryCore::class,
    ];

    /**
     * Bootstrap services.
     */
    public function boot(): void
    {
        //
    }
}
