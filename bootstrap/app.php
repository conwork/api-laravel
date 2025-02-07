<?php

use App\Http\Middleware\AcceptJson;
use Illuminate\Foundation\Application;
use Illuminate\Foundation\Configuration\Exceptions;
use Illuminate\Foundation\Configuration\Middleware;

return Application::configure(basePath: dirname(__DIR__))
    ->withRouting(
        // web: __DIR__.'/../routes/web.php',
        api: __DIR__.'/../routes/api.php',
        apiPrefix: '',
        commands: __DIR__.'/../routes/console.php',
        health: '/up',
    )
    ->withMiddleware(function (Middleware $middleware) {
        $middleware->priority([
            AcceptJson::class, // prevents sanctum to over-rule and return html if missing 'Accept: "application/json"' header
        ]);
    })
    ->withExceptions(function (Exceptions $exceptions) {
        //
    })->create();
