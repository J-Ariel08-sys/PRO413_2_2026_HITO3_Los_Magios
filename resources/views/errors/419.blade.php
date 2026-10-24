@extends('layouts.app')
@section('titulo', 'La sesión ha vencido')
@section('contenido')
<div class="card empty error-screen"><p class="eyebrow">ERROR 419</p><h1>La sesión ha vencido</h1><p>Vuelve al formulario y actualiza la página antes de guardar.</p><a class="button primary" href="{{ route('estudiantes.index') }}">Volver a estudiantes</a></div>
@endsection
