<?php
declare(strict_types=1);

use App\Http\Controllers\Authentication\AuthController;
use App\Http\Controllers\Test\TestController;
use App\Http\Controllers\User\UserController;
use Illuminate\Support\Facades\Route;


/*
 * +--------------------------------------+
 * |        ROTAS PÚBLICAS (v1)           |
 * +--------------------------------------+
 */
Route::prefix('v1')->name('api.v1.')->group(function () {

    Route::controller(AuthController::class)
        ->prefix('auth')
        ->middleware('throttle:10,1')
        ->name('auth.')
        ->group(function () {

            // Autenticação
            Route::post('/register', 'register')->name('register');
            Route::post('/login', 'login')->name('login');
            Route::post('/refresh', 'refresh')->name('refresh');

            // Rotas protegidas de autenticação
            Route::middleware('auth:api')->group(function () {
                Route::put('/update-pwd/{id}', 'updatePassword')->name('update.password');
                Route::post('/logout', 'logout')->name('logout');
                Route::get('/me', 'me')->name('me'); // Dados do usuário logado
            });
    });

    /*
     * +--------------------------------------+
     * |        ROTAS PROTEGIDAS (v1)         |
     * +--------------------------------------+
     */
    Route::middleware('auth:api')->name('private.')->group(function () {

        Route::apiResource('user', UserController::class)->except(['store']);

        // Futuros recursos do e-commerce
        // Route::apiResource('products', ProductController::class);
        // Route::apiResource('categories', CategoryController::class);
        // Route::apiResource('orders', OrderController::class);
    });
});

/*
 * +--------------------------------------+
 * |           ROTAS DE TESTE             |
 * +--------------------------------------+
 * Remover em produção ou proteger com
 * middleware de ambiente
 */
if (config('app.env') !== 'production') {
    Route::prefix('test')->middleware('auth:api')->group(function () {
        Route::get('/', [TestController::class, 'test'])->name('test.route');
    });
}
