<?php

use Illuminate\Http\Request;
use Illuminate\Foundation\Application;
use Illuminate\Auth\AuthenticationException;
use Illuminate\Foundation\Configuration\Exceptions;
use Illuminate\Foundation\Configuration\Middleware;

return Application::configure(basePath: dirname(__DIR__))
    ->withRouting(
        web: __DIR__ . '/../routes/web.php',
        api: __DIR__ . '/../routes/api.php',
        commands: __DIR__ . '/../routes/console.php',
        health: '/up',
    )
    ->withMiddleware(function (Middleware $middleware) {
        //
    })
    ->withExceptions(function (Exceptions $exceptions) {
        //
        $exceptions->render(function (AuthenticationException $e, Request $request) {
            if ($request->is('api/*')) {
                return response()->json([
                    'statusCode' => 403,
                    'status' => "error",
                    'message' => 'Forbidden'
                ], 403);
            }
            // Handle other exceptions or default response here
            return $e->render($request);
        });

        if (env('APP_ENV') == 'production') {
            $exceptions->render(function (\Throwable $e, Request $request) {
                if ($request->is('api/*')) {
                    return response()->json([
                        'statusCode' => 500,
                        'status' => "error",
                        'message' => 'Internal Server Error'
                    ], 500);
                }
                return $e->render($request);
            });
        }
    })->create();
