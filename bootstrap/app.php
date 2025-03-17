<?php

use Illuminate\Foundation\Application;
use Illuminate\Foundation\Configuration\Exceptions;
use Illuminate\Foundation\Configuration\Middleware;
use Spatie\Permission\Middleware\RoleMiddleware;
use Spatie\Permission\Middleware\PermissionMiddleware;

return Application::configure(basePath: dirname(__DIR__))
    ->withRouting(
        web: __DIR__.'/../routes/web.php',
        commands: __DIR__.'/../routes/console.php',
        health: '/up',
    )
    ->withMiddleware(function (Middleware $middleware) {
        // Enregistrement des middlewares personnalisés
        $middleware->alias([
            'role' => RoleMiddleware::class,         // Middleware pour vérifier le rôle
            'permission' => PermissionMiddleware::class, // Middleware pour vérifier les permissions
        ]);
    })
    ->withExceptions(function (Exceptions $exceptions) {
        // Gestion des exceptions personnalisées (si nécessaire)
    })->create();
