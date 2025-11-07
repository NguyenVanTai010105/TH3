<?php

use App\Http\Middleware\CheckAccessTime;
use Illuminate\Foundation\Application;
use Illuminate\Foundation\Configuration\Exceptions;
use Illuminate\Foundation\Configuration\Middleware;

return Application::configure(basePath: dirname(__DIR__))
    ->withRouting(
        web: __DIR__ . '/../routes/web.php',
        commands: __DIR__ . '/../routes/console.php',
        health: '/up',
    )
    ->withMiddleware(function (Middleware $middleware): void {
        //Global Middleware
      //  $middleware->append(CheckAccessTime::class);
        // $middleware->alias(
        //     ['access.time'  => CheckAccessTime::class]
    
        // );
    })
    ->withExceptions(function (Exceptions $exceptions): void {
        //
    })->create();
