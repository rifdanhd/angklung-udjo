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
        'setlocale' => \App\Http\Middleware\SetLocale::class,
        'honeypot'  => \App\Http\Middleware\PreventSpamHoneypot::class,
    ]);
    $middleware->web(append: [
        \App\Http\Middleware\SetLocale::class,
        \App\Http\Middleware\SecurityHeaders::class,
    ]);
})
    ->withExceptions(function (Exceptions $exceptions): void {

        // Kalau belum login & coba akses admin → tampilkan 404 agar login tersembunyi
        $exceptions->render(function (
            \Illuminate\Auth\AuthenticationException $e,
            \Illuminate\Http\Request $request
        ) {
            abort(404);
        });

    })
    ->create();