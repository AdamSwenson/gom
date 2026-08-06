<?php

use Illuminate\Foundation\Application;
use Illuminate\Foundation\Configuration\Exceptions;
use Illuminate\Foundation\Configuration\Middleware;
use Illuminate\Support\Facades\Route;

return Application::configure(basePath: dirname(__DIR__))
    ->withRouting(
        using: function (): void {
            Route::get('/up', App\Http\Controllers\HealthController::class);

            Route::middleware('web')
                ->namespace('App\\Http\\Controllers')
                ->group(base_path('routes/web.php'));

            Route::middleware('api')
                ->prefix('api')
                ->namespace('App\\Http\\Controllers')
                ->group(base_path('routes/api.php'));
        },
        commands: __DIR__.'/../routes/console.php',
        health: '/up',
    )
    ->withMiddleware(function (Middleware $middleware): void {
        $middleware->alias([
            'auth' => Illuminate\Auth\Middleware\Authenticate::class,
            'auth.basic' => Illuminate\Auth\Middleware\AuthenticateWithBasicAuth::class,
            'bindings' => Illuminate\Routing\Middleware\SubstituteBindings::class,
            'can' => Illuminate\Auth\Middleware\Authorize::class,
            'guest' => App\Http\Middleware\RedirectIfAuthenticated::class,
            'throttle' => Illuminate\Routing\Middleware\ThrottleRequests::class,
            'restrictRegistration' => App\Http\Middleware\RestrictToInstitutions::class,
            'logAllRequests' => App\Http\Middleware\LogAllRequests::class,
        ]);
    })
    ->withExceptions(function (Exceptions $exceptions): void {
        // Application exception reporting is registered by App\Exceptions\Handler.
    })
    ->create();
