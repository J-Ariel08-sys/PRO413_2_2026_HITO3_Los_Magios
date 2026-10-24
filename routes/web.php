<?php

declare(strict_types=1);

use App\Http\Controllers\DocenteController;
use App\Http\Controllers\EstudianteController;
use Illuminate\Support\Facades\Route;

Route::redirect('/', '/estudiantes');
Route::resource('estudiantes', EstudianteController::class)
    ->parameters(['estudiantes' => 'estudiante']);

// Parte 3: módulo de docentes (base institucional en la red local).
Route::resource('docentes', DocenteController::class)->only(['index', 'store']);
