@extends('layouts.app')
@section('titulo', 'Registro no encontrado')
@section('contenido')
<div class="card empty error-screen"><p class="eyebrow">ERROR 404</p><h1>Registro no encontrado</h1><p>El estudiante o la página que buscas no existe.</p><a class="button primary" href="{{ route('estudiantes.index') }}">Volver a estudiantes</a></div>
@endsection
