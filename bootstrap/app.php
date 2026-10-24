<?php

declare(strict_types=1);

use Illuminate\Database\QueryException;
use Illuminate\Foundation\Application;
use Illuminate\Foundation\Configuration\Exceptions;
use Illuminate\Foundation\Configuration\Middleware;
use Illuminate\Http\Request;

return Application::configure(basePath: dirname(__DIR__))
    ->withRouting(
        web: __DIR__.'/../routes/web.php',
        commands: __DIR__.'/../routes/console.php',
        health: '/up',
    )
    ->withMiddleware(function (Middleware $middleware): void {
        // Las rutas web conservan la protección CSRF de Laravel.
    })
    ->withExceptions(function (Exceptions $exceptions): void {
        $exceptions->render(function (QueryException $exception, Request $request) {
            $integridad = str_starts_with((string) $exception->getCode(), '23');
            $mensaje = $integridad
                ? 'No se pudo guardar o eliminar: hay un dato duplicado o registros relacionados. Revisa los datos e inténtalo de nuevo.'
                : 'No se pudo acceder a la base de datos. Revisa la conexión y vuelve a intentarlo.';
            $estado = $integridad ? 409 : 503;
            if ($request->expectsJson()) {
                return response()->json(['message' => $mensaje], $estado);
            }
            return response()->view('errors.database', ['mensaje' => $mensaje, 'estado' => $estado], $estado);
        });
    })->create();
