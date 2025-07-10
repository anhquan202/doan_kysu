<?php

use App\Http\Middleware\Auth;
use App\Http\Middleware\CheckPermission;
use App\Http\Middleware\CheckRoles;
use App\Http\Middleware\CheckUserPrivilegeByRoleLevel;
use Illuminate\Foundation\Application;
use Illuminate\Foundation\Configuration\Exceptions;
use Illuminate\Foundation\Configuration\Middleware;

return Application::configure(basePath: dirname(__DIR__))
    ->withRouting(
        web: __DIR__ . '/../routes/web.php',
        api: __DIR__ . '/../routes/api.php',
        commands: __DIR__ . '/../routes/console.php',
        health: '/up',
    )
    ->withMiddleware(function (Middleware $middleware): void {
        $middleware->alias([
            'auth.jwt.custom' => Auth::class,
            'roles' => CheckRoles::class,
            'permissions' => CheckPermission::class,
            'user.privilege.role-level' => CheckUserPrivilegeByRoleLevel::class
        ]);
    })
    ->withExceptions(function (Exceptions $exceptions): void {
        //
    })->create();
