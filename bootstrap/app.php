<?php

use Illuminate\Foundation\Application;
use Illuminate\Foundation\Configuration\Exceptions;
use Illuminate\Foundation\Configuration\Middleware;


return Application::configure(basePath: dirname(__DIR__))
    // registrē maršrutus,
    ->withRouting(
        web: __DIR__.'/../routes/web.php',        // Parastie mājaslapas maršruti un skati
        commands: __DIR__.'/../routes/console.php', // Artisan komandas terminālim
        health: '/up',                              // Automātiskā sistēmas darbības pārbaudes adrese
    )
    
    ->withMiddleware(function (Middleware $middleware) {
        // Tulkojums
        $middleware->web(append: [
            \App\Http\Middleware\SetLocale::class,
        ]);
    })
    // Kludu apstrade
    ->withExceptions(function (Exceptions $exceptions) {
        
    })->create(); 