<?php

use App\Http\Middleware\CheckRole;
use Illuminate\Foundation\Application;
use Illuminate\Foundation\Configuration\Exceptions;
use Illuminate\Foundation\Configuration\Middleware;
<<<<<<< HEAD
use Illuminate\Auth\Middleware\Authenticate;
use Illuminate\Foundation\Http\Middleware\VerifyCsrfToken;
=======
use App\Http\Middleware\UpdateLastSeenMiddleware;
>>>>>>> origin/master


return Application::configure(basePath: dirname(__DIR__))
    ->withRouting(
        web: __DIR__ . '/../routes/web.php',
        commands: __DIR__ . '/../routes/console.php',
        channels: __DIR__.'/../routes/channels.php',
        health: '/up',
    )
    ->withMiddleware(
        function (Middleware $middleware) {
<<<<<<< HEAD
            // Alias middleware 'role' to CheckRole::class
            $middleware->alias([
                'role' => CheckRole::class,
                'auth' => Authenticate::class, // Ensure 'auth' middleware is defined
                'csrf' => VerifyCsrfToken::class, // CSRF protection
            ]);
        }
=======
            $middleware->alias([
                'role' => CheckRole::class,
                'update.last.seen' => UpdateLastSeenMiddleware::class
            
            ]);
        },
      
>>>>>>> origin/master
    )
    ->withExceptions(function (Exceptions $exceptions) {
        // You can add exception handling here if needed
    })->create();
