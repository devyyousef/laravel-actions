<?php

use App\Http\Resources\ErrorResponseResource;
use Illuminate\Auth\AuthenticationException;
use Illuminate\Foundation\Application;
use Illuminate\Foundation\Configuration\Exceptions;
use Illuminate\Foundation\Configuration\Middleware;
use Illuminate\Http\Request;
use Illuminate\Validation\ValidationException;
use Spatie\Permission\Exceptions\UnauthorizedException;
use Symfony\Component\HttpKernel\Exception\HttpException;
use Symfony\Component\HttpKernel\Exception\NotFoundHttpException;






return Application::configure(basePath: dirname(__DIR__))
    ->withRouting(
        web: __DIR__ . '/../routes/web.php',
        api: __DIR__ . '/../routes/api.php',
        commands: __DIR__ . '/../routes/console.php',
        health: '/up',
    )
    ->withMiddleware(function (Middleware $middleware) {
        $middleware->alias([
            'role' => \Spatie\Permission\Middleware\RoleMiddleware::class,
            'permission' => \Spatie\Permission\Middleware\PermissionMiddleware::class,
            'role_or_permission' => \Spatie\Permission\Middleware\RoleOrPermissionMiddleware::class,
        ]);
    })
    ->withExceptions(function (Exceptions $exceptions) {
        $exceptions->render(function (Throwable $e, Request $request) {
            if ($e instanceof ValidationException) {
                return new ErrorResponseResource(
                    __('Translation::error_messages.validation_error'),
                    422,
                    $e->errors()
                );
            }

            if ($e instanceof NotFoundHttpException) {
                return new ErrorResponseResource(__('Translation::error_messages.resource_not_found'), 404, null);
            }

            if ($e instanceof HttpException) {
                return new ErrorResponseResource($e->getMessage(), $e->getStatusCode(), null);
            }

            if ($e instanceof \Illuminate\Auth\AuthenticationException) {
                return new ErrorResponseResource(__('Translation::error_messages.unauthorized'), 401, null);
            }
        });
    })->create();
