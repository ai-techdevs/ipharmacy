<?php

use Illuminate\Foundation\Application;
use App\Http\Middleware\AdminAuthenticate;
use App\Http\Middleware\Authenticate;
use App\Http\Middleware\RoleAuthorization;
use App\Http\Middleware\PreventBackHistory;
use Illuminate\Foundation\Configuration\Exceptions;
use Illuminate\Foundation\Configuration\Middleware;

return Application::configure(basePath: dirname(__DIR__))
    ->withRouting(
        web: [
            __DIR__.'/../routes/web.php',
            __DIR__.'/../routes/admin.php', // Prefix 'admin' for admin routes
        ],
        commands: __DIR__.'/../routes/console.php',
        health: '/up',
    )
    ->withMiddleware(function (Middleware $middleware) {
        $middleware->alias([
            'auth.admin' => AdminAuthenticate::class,
            'preventBackHistory' => PreventBackHistory::class,
            'role.auth' => RoleAuthorization::class,
             'auth' => Authenticate::class,
        ]);
           $middleware->validateCsrfTokens(except: [
            'paypal/webhook',
            'paypal/*', 
        ]);
    })
    ->withSchedule(function (\Illuminate\Console\Scheduling\Schedule $schedule) {
        $schedule->command('cdc:import')->daily();
    })
    ->withExceptions(function (Exceptions $exceptions) {
        //
    })->create();
