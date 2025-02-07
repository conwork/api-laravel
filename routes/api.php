<?php

use Illuminate\Support\Facades\Route;
use App\Http\Middleware\AcceptJson;
use App\Http\Controllers\HomeController;
use App\Http\Controllers\AuthController;

Route::middleware([AcceptJson::class, 'api'])->group(function () {
    Route::prefix('auth')->controller(AuthController::class)->group(function () {
        Route::post('/login', 'login')->name('auth.login');
        Route::get('/logout', 'logout')->middleware(['auth:sanctum'])->name('auth.logout');
    });

    Route::middleware(['auth:sanctum'])->group(function () {
        Route::get('/', [HomeController::class, 'index'])->name('home');
    });
});
