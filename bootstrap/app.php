<?php

use App\Http\Trait\ApiResponse;
use Illuminate\Foundation\Application;
use Illuminate\Auth\AuthenticationException;
use Illuminate\Validation\ValidationException;
use Illuminate\Foundation\Configuration\Exceptions;
use Illuminate\Foundation\Configuration\Middleware;
use Illuminate\Database\Eloquent\ModelNotFoundException;
use Symfony\Component\HttpKernel\Exception\NotFoundHttpException;
use Symfony\Component\HttpKernel\Exception\MethodNotAllowedHttpException;

return Application::configure(basePath: dirname(__DIR__))
    // use ApiResponse; 
    ->withRouting(
        web: __DIR__ . '/../routes/web.php',
        api: __DIR__ . '/../routes/api.php',
        commands: __DIR__ . '/../routes/console.php',
        health: '/up',
    )
    ->withMiddleware(function (Middleware $middleware): void {
        //
    })
    ->withExceptions(function (Exceptions $exceptions): void {
        $exceptions->renderable(function (MethodNotAllowedHttpException $e, $request) {
            return ApiResponse::error(['error' => $e->getMessage()], 'Method not allowed', 405);
        });

        $exceptions->renderable(function (ValidationException $e, $request) {
            return ApiResponse::error(['errors' => $e->errors() ], 'Validation failed', 422);
        });

        $exceptions->renderable(function (ModelNotFoundException $e, $request) {
            return ApiResponse::error(['error' => 'Resource not found'], 'Model not found', 404);
        });

        $exceptions->renderable(function (AuthenticationException $e, $request) {
            return ApiResponse::error(['error' => 'Unauthenticated'], 'Authentication error', 401);
        });

        $exceptions->renderable(function (NotFoundHttpException $e, $request) {
            return ApiResponse::error(['error' => 'Endpoint not found'], 'Route not found', 404);
        });
    })->create();
