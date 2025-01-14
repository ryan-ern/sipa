<?php

use App\Http\Middleware\Guest;
use App\Http\Middleware\Role;
use Illuminate\Foundation\Application;
use Illuminate\Foundation\Configuration\Exceptions;
use Illuminate\Foundation\Configuration\Middleware;

return Application::configure(basePath: dirname(__DIR__))
  ->withRouting(
    web: __DIR__ . '/../routes/web.php',
    commands: __DIR__ . '/../routes/console.php',
    health: '/up',
  )
  ->withMiddleware(function (Middleware $middleware) {
    $middleware->alias([
      'role' => Role::class,
      'guest' => Guest::class,
    ]);
  })
  ->withExceptions(function (Exceptions $exceptions) {
    $exceptions->renderable(function (\Exception $e) {
      if ($e->getPrevious() instanceof \Illuminate\Session\TokenMismatchException) {
        return back()->with('info', 'Sesi anda telah habis, silahkan login kembali!');
      };
    });
  })->create();
