@extends('layouts.app')
@section('titulo', 'Editar estudiante')
@section('contenido')
<a class="back" href="{{ route('estudiantes.show', $estudiante) }}">← Volver a la ficha</a>
<div class="page-heading"><div><p class="eyebrow">ACTUALIZAR REGISTRO</p><h1>Editar estudiante</h1><p class="muted">{{ $estudiante->nombre_completo }} · {{ $estudiante->codigo }}</p></div></div>
<section class="card form-card"><div class="card-heading"><h2>Información del estudiante</h2></div><form action="{{ route('estudiantes.update', $estudiante) }}" method="POST" class="student-form">@method('PUT') @include('estudiantes._form', ['textoBoton' => 'Guardar cambios'])</form></section>
@endsection
