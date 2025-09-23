<?php

use Illuminate\Foundation\Application;
use Illuminate\Foundation\Configuration\Exceptions;
use Illuminate\Foundation\Configuration\Middleware;

return Application::configure(basePath: dirname(__DIR__))
    ->withRouting(
        web: __DIR__.'/../routes/web.php',
        api: __DIR__.'/../routes/api.php',
        commands: __DIR__.'/../routes/console.php',
        health: '/up',
    )
    ->withMiddleware(function (Middleware $middleware): void {
        // Register any global middleware or middleware groups here if needed
    })
    ->withExceptions(function (Exceptions $exceptions): void {
        // Register our custom exception handler
        $exceptions->render(function (\Throwable $e, $request) {
            // Handle API requests automatically
            if ($request->expectsJson() || $request->is('api/*')) {
                return app(\App\Exceptions\Handler::class)->handleApiException($e);
            }
        });
    })
  
    ->create();
