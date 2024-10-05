<?php

use App\Http\Middleware\AdminAuth;
use App\Http\Middleware\ClientAuth;
use App\Http\Middleware\ClientGuest;
use Illuminate\Foundation\Application;
use Illuminate\Foundation\Configuration\Exceptions;
use Illuminate\Foundation\Configuration\Middleware;

return Application::configure(basePath: dirname(__DIR__))
    ->withRouting(
        web: __DIR__.'/../routes/web.php',
        commands: __DIR__.'/../routes/console.php',
        health: '/up',
    )
    ->withMiddleware(function (Middleware $middleware) {     //
        $middleware->alias([
            'admin-auth' => AdminAuth::class,
            'client-auth' => ClientAuth::class,
            'client-guest' => ClientGuest::class,
        ]); 
    })
    ->withExceptions(function (Exceptions $exceptions) {
        //
    })->create();
