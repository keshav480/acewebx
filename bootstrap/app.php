<?php

use Illuminate\Foundation\Application;
use Illuminate\Foundation\Configuration\Exceptions;
use Illuminate\Foundation\Configuration\Middleware; // This is correct type

return Application::configure(basePath: dirname(__DIR__))
    ->withRouting(
        web: __DIR__.'/../routes/web.php',
        commands: __DIR__.'/../routes/console.php',
        health: '/up',
    )
    ->withMiddleware(function (Middleware $middleware): void {
        $middleware->alias([
        'load.smtp' => \App\Http\Middleware\LoadSmtpSettings::class,
    ]);
    })
    ->withExceptions(function (Exceptions $exceptions): void {
        //
    })
    ->create();
