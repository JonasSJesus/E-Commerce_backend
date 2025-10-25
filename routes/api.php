<?php
declare(strict_types=1);

use App\Http\Controllers\AuthController;
use App\Http\Controllers\TestController;
use App\Http\Controllers\UserController;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;


/*
 * +--------------------------------------+
 * |           ROTAS DE TESTES            |
 * +--------------------------------------+
 */
Route::prefix('v1')->group(function (){
    Route::middleware('auth:api')
        ->group(function () {
            Route::get('/test', [TestController::class, 'test']);
        }
        )->name('test.route');


    /*
     * +--------------------------------------+
     * |           ROTAS DO SISTEMA           |
     * +--------------------------------------+
     */
    Route::post('/login', [AuthController::class, 'login'])->name('login');

    Route::controller(UserController::class)->group(function () {
            Route::post('/user', 'store');

            Route::middleware('auth:api')->group(function () {
                Route::get('/user', 'index');
                Route::get('/user/{id}', 'show');
                Route::put('/user/{id}', 'update');
                Route::delete('/user/{id}', 'destroy');
            });
        });

});
