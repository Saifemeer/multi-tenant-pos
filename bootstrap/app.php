<?php

use Illuminate\Foundation\Application;
use Illuminate\Foundation\Configuration\Exceptions;
use Illuminate\Foundation\Configuration\Middleware;

return Application::configure(basePath: dirname(__DIR__))
    ->withRouting(
        web: __DIR__.'/../routes/web.php',
        commands: __DIR__.'/../routes/console.php',
        health: '/up',
    )
    ->withMiddleware(function (Middleware $middleware) {
        $middleware->alias([
            'tenant.active' => \App\Http\Middleware\EnsureTenantIsActive::class,
             'super_admin'   => \App\Http\Middleware\EnsureUserIsSuperAdmin::class,
             'not.cashier'   => \App\Http\Middleware\EnsureNotCashier::class,
             'tenant.admin'  => \App\Http\Middleware\EnsureIsAdmin::class,
        ]);
         $middleware->validateCsrfTokens(except: [
        'stripe/webhook',
    ]);
    })
    ->withExceptions(function (Exceptions $exceptions) {
        //
    })->create();