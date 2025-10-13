<?php

use App\Http\Controllers\AuthController;
use App\Http\Controllers\TestController;
use App\Http\Controllers\UserController;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;

Route::post('/login', [AuthController::class, 'login'])->name('login');
Route::post('/create', [UserController::class, 'store']);


Route::middleware('auth:api')->group(function () {
        Route::get('/test', [TestController::class, 'test']);
    }
)->name('test.route');
