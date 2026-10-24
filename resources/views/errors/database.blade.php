@extends('layouts.app')
@section('titulo', 'No se pudo completar la operación')
@section('contenido')
<div class="card empty error-screen"><p class="eyebrow">ERROR {{ $estado }}</p><h1>No se pudo completar la operación</h1><p>{{ $mensaje }}</p><a class="button primary" href="{{ route('estudiantes.index') }}">Volver a estudiantes</a></div>
@endsection
