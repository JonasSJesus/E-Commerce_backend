<?php
declare(strict_types=1);

namespace App\Providers;

use App\Repositories\Jwt\Contracts\JwtSessionRepository;
use App\Repositories\Jwt\Core\JwtSessionRepositoryCore;
use App\Repositories\Product\Contracts\ProductRepository;
use App\Repositories\Product\Core\ProductRepositoryCore;
use App\Repositories\User\Contracts\UserRepository;
use App\Repositories\User\Core\UserRepositoryCore;
use Illuminate\Support\ServiceProvider;

class RepositoryServiceProvider extends ServiceProvider
{
    public array $bindings = [
        UserRepository::class       => UserRepositoryCore::class,
        JwtSessionRepository::class => JwtSessionRepositoryCore::class,
        ProductRepository::class    => ProductRepositoryCore::class,
    ];

    /**
     * Bootstrap services.
     */
    public function boot(): void
    {
        //
    }
}
