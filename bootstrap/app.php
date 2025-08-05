<?php

use Illuminate\Foundation\Application;
use App\Console\Commands\CheckSubscriptionsCommand;
use Illuminate\Foundation\Configuration\Exceptions;
use Illuminate\Foundation\Configuration\Middleware;

return Application::configure(basePath: dirname(__DIR__))
    ->withRouting(
        web: __DIR__.'/../routes/web.php',
        commands: __DIR__.'/../routes/console.php',
        health: '/up',
    )
    ->withMiddleware(function (Middleware $middleware) {
        //
        $middleware->alias([
            'subscription' => \App\Http\Middleware\CheckSubscription::class
        ]);
        
        
    })
    ->withExceptions(function (Exceptions $exceptions) {
        // Register custom renderer for specific HTTP error codes
        $exceptions->render(function (HttpException $e, Request $request) {
            $status = $e->getStatusCode();
            
            // Custom views for different error codes
            if ($request->expectsJson()) {
                return response()->json([
                    'message' => $e->getMessage() ?: __('errors.' . $status),
                    'code' => $status
                ], $status);
            }
            
            // Custom error pages for web requests
            $view = match($status) {
                401 => 'errors.401',
                403 => 'errors.403',
                404 => 'errors.404',
                419 => 'errors.419',
                429 => 'errors.429',
                500 => 'errors.500',
                503 => 'errors.503',
                default => 'errors.default'
            };
            
            return response()->view($view, [
                'message' => $e->getMessage(),
                'code' => $status
            ], $status);
        });
        
        // Report specific exceptions to different channels
        $exceptions->reportable(function (InvalidOrderException $e) {
            // Send to bug tracking service
        });
        
        // Ignore certain exceptions
        $exceptions->dontReport([
            AuthenticationException::class,
            AuthorizationException::class,
            ModelNotFoundException::class,
            ValidationException::class,
        ]);
    })

     ->withCommands([
        CheckSubscriptionsCommand::class,
    ])
    ->create();

