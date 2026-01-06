<?php

use Illuminate\Foundation\Application;
use Illuminate\Foundation\Configuration\Exceptions;
use Illuminate\Foundation\Configuration\Middleware;
// Import class middleware-nya
use App\Http\Middleware\IsKepala;

return Application::configure(basePath: dirname(__DIR__))
    ->withRouting(
        web: __DIR__ . '/../routes/web.php',
        commands: __DIR__ . '/../routes/console.php',
        health: '/up',
    )
    ->withMiddleware(function (Middleware $middleware) {

        // Daftarkan alias di sini
        $middleware->alias([
            'is_kepala' => IsKepala::class,
            'is_admin'  => \App\Http\Middleware\IsAdmin::class, // Jika sudah ada sebelumnya
        ]);
    })
    ->withExceptions(function (Exceptions $exceptions) {
        //
    })->create();
