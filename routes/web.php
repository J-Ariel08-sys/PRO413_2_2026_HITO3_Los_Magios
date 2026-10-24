<?php

declare(strict_types=1);

use App\Http\Controllers\EstudianteController;
use Illuminate\Support\Facades\Route;

Route::redirect('/', '/estudiantes');
Route::resource('estudiantes', EstudianteController::class)
    ->parameters(['estudiantes' => 'estudiante']);
