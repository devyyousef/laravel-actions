<?php

use App\Http\Resources\ErrorResponseResource;
use Illuminate\Auth\AuthenticationException;
use Illuminate\Foundation\Application;
use Illuminate\Foundation\Configuration\Exceptions;
use Illuminate\Foundation\Configuration\Middleware;
use Spatie\Permission\Exceptions\UnauthorizedException;
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
        $exceptions->render(function (Throwable $th) {
            if ($th instanceof AuthenticationException) {
                return new ErrorResponseResource(
                    __('Unauthorized'),
                    401,
                );
            }
            if ($th instanceof UnauthorizedException) {
                return new ErrorResponseResource(
                    __('User does not have the right roles'),
                    403,
                );
            }
            if($th instanceof NotFoundHttpException) {
                return new ErrorResponseResource(
                    __('Resource not found'),
                    404,
                );
            }
        });
    })->create();
