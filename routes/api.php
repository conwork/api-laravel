<?php

use App\Http\Controllers\ArticleController;
use Illuminate\Support\Facades\Route;
use App\Http\Middleware\AcceptJson;
use App\Http\Controllers\HomeController;
use App\Http\Controllers\AuthController;
use Mcamara\LaravelLocalization\Facades\LaravelLocalization;


Route::middleware([AcceptJson::class, 'api'])->group(function () {
    Route::prefix('auth')->controller(AuthController::class)->group(function () {
        Route::post('/login', 'login')->name('auth.login');
        Route::get('/logout', 'logout')->middleware(['auth:sanctum'])->name('auth.logout');
    });

    Route::group(['prefix' => LaravelLocalization::setLocale(),'middleware' => ['auth:sanctum', 'user.preferences']
    ], function () {
        Route::get('/', [HomeController::class, 'index'])->name('home');
        Route::apiResource('articles', ArticleController::class);
    });
});

