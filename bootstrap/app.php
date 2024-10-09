<?php

use App\Http\Middleware\CheckRole;
use Illuminate\Foundation\Application;
use Illuminate\Foundation\Configuration\Exceptions;
use Illuminate\Foundation\Configuration\Middleware;
use Illuminate\Auth\Middleware\Authenticate;
use Illuminate\Foundation\Http\Middleware\VerifyCsrfToken;


return Application::configure(basePath: dirname(__DIR__))
    ->withRouting(
        web: __DIR__ . '/../routes/web.php',
        commands: __DIR__ . '/../routes/console.php',
        health: '/up',
    )
    ->withMiddleware(
        function (Middleware $middleware) {
            // Alias middleware 'role' to CheckRole::class
            $middleware->alias([
                'role' => CheckRole::class,
                'auth' => Authenticate::class, // Ensure 'auth' middleware is defined
                'csrf' => VerifyCsrfToken::class, // CSRF protection
            ]);
        }
    )
    ->withExceptions(function (Exceptions $exceptions) {
        // You can add exception handling here if needed
    })->create();
