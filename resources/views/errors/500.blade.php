@extends('layouts.app')
@section('titulo', 'No se pudo completar la operación')
@section('contenido')
<div class="card empty error-screen"><p class="eyebrow">ERROR 500</p><h1>No se pudo completar la operación</h1><p>Ocurrió un error inesperado. Inténtalo de nuevo.</p><a class="button primary" href="{{ route('estudiantes.index') }}">Volver a estudiantes</a></div>
@endsection
