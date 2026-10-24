@extends('layouts.app')
@section('titulo', 'Registrar estudiante')
@section('contenido')
<a class="back" href="{{ route('estudiantes.index') }}">← Volver a estudiantes</a>
<div class="page-heading"><div><p class="eyebrow">REGISTRO ACADÉMICO</p><h1>Nuevo estudiante</h1><p class="muted">Completa sus datos para incorporarlo al directorio.</p></div></div>
<section class="card form-card"><div class="card-heading"><h2>Información del estudiante</h2></div><form action="{{ route('estudiantes.store') }}" method="POST" class="student-form">@include('estudiantes._form', ['textoBoton' => 'Registrar estudiante'])</form></section>
@endsection
