<?php

declare(strict_types=1);

use App\Http\Controllers\DocenteController;
use App\Http\Controllers\EstudianteController;
use App\Http\Controllers\ReporteController;
use Illuminate\Support\Facades\Route;

Route::redirect('/', '/estudiantes');
Route::resource('estudiantes', EstudianteController::class)
    ->parameters(['estudiantes' => 'estudiante']);

Route::get('/docentes', [DocenteController::class, 'index'])->name('docentes.index');
Route::post('/docentes', [DocenteController::class, 'store'])->name('docentes.store');

Route::get('/reporte-consolidado', [ReporteController::class, 'index'])
    ->name('reporte-consolidado');
