<?php
declare(strict_types=1);

use App\Http\Controllers\Authentication\AuthController;
use App\Http\Controllers\Product\ProductController;
use App\Http\Controllers\Test\TestController;
use App\Http\Controllers\User\UserController;
use Illuminate\Support\Facades\Route;


/*
 * +--------------------------------------+
 * |        ROTAS PÚBLICAS (v1)           |
 * +--------------------------------------+
 */
Route::prefix('v1')->name('api.v1.')->group(function () {

    /** Rotas De Autenticação */
    Route::controller(AuthController::class)
        ->prefix('auth')
        ->middleware('throttle:10,1')
        ->name('auth.')
        ->group(function () {

            // Registro e Login
            Route::post('/register', 'register')->name('register');
            Route::post('/login', 'login')->name('login');

            // Rotas protegidas de autenticação
            Route::middleware(['auth:api', 'validateJwtSession'])
                ->name('private.')
                ->group(function () {
                    Route::post('/refresh', 'refresh')->name('refresh');
                    Route::put('/update-pwd/{id}', 'updatePassword')->name('update.password');
                    Route::delete('/logout', 'logout')->name('logout');
                    Route::get('/me', 'me')->name('me'); // Dados do usuário logado
            });

    });
    /** Rotas de Produtos */
    Route::controller(ProductController::class)->prefix('products')->name('products.')->group(function () {
        Route::get('/search/{query}', 'search')->name('search');
        Route::get('/index', 'index')->name('index');
        Route::get('/show/{id}', 'show')->name('show');
    });

    /*
     * +--------------------------------------+
     * |        ROTAS PROTEGIDAS (v1)         |
     * +--------------------------------------+
     */
    Route::middleware(['auth:api', 'validateJwtSession'])->name('private.')->group(function () {

        Route::apiResource('user', UserController::class)->only(['show', 'update', 'destroy']);

        // Futuros recursos do e-commerce
        // Route::apiResource('orders', OrderController::class);
    });
});

/*
 * +--------------------------------------+
 * |           ROTAS DE TESTE             |
 * | Remover em produção ou proteger com  |
 * |       middleware de ambiente         |
 * +--------------------------------------+
 */
if (config('app.env') !== 'production') {
    Route::prefix('test')->middleware('auth:api')->group(function () {
        Route::get('/', [TestController::class, 'test'])->name('test.route');
        Route::post('/', [TestController::class, 'test'])->name('test.route');
        Route::put('/', [TestController::class, 'test'])->name('test.route');
    });
}
