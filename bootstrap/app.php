<?php

use Illuminate\Foundation\Application;
use Illuminate\Foundation\Configuration\Exceptions;
use Illuminate\Foundation\Configuration\Middleware;

return Application::configure(basePath: dirname(__DIR__))
    ->withRouting(
        web: __DIR__.'/../routes/web.php',
        commands: __DIR__.'/../routes/console.php',
        health: '/up',
    )
    ->withMiddleware(function (Middleware $middleware) {
        $middleware->alias([
            'manager.active' => \App\Http\Middleware\EnsureManagerIsActive::class,
            'manager.active' => \App\Http\Middleware\ManagerActive::class,
            // Add other middleware aliases as needed
        ]);
    })
    ->withExceptions(function (Exceptions $exceptions) {
        //
    })->create();
