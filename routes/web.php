<?php

use Illuminate\Support\Facades\Route;
use App\Models\Cliente;

Route::get('/', function () {
    // Consulta al cliente id_cliente = 1 en la BD externa
    $cliente = Cliente::find(1);

    return view('welcome', compact('cliente'));
});