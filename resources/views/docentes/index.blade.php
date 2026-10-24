@extends('layouts.app')
@section('titulo', 'Docentes')
@section('contenido')
<div class="page-heading">
    <div>
        <p class="eyebrow">COMUNIDAD ACADÉMICA</p>
        <h1>Docentes</h1>
        <p class="muted">Personal académico registrado en la base institucional.</p>
    </div>
</div>
@if(isset($errorRed) && $errorRed)
    <div class="alert error" role="alert">{{ $errorRed }}</div>
@endif
@if(session('success'))
    <div class="alert success" role="status">{{ session('success') }}</div>
@endif
<section class="card form-card">
    <div class="card-heading"><h2>Registrar docente</h2></div>
    <form action="{{ route('docentes.store') }}" method="POST" class="student-form">
        @csrf
        <div class="form-grid">
            <div><label for="nombre">Nombre</label><input id="nombre" type="text" name="nombre" maxlength="100" value="{{ old('nombre') }}" required></div>
            <div><label for="especialidad">Especialidad</label><input id="especialidad" type="text" name="especialidad" maxlength="100" value="{{ old('especialidad') }}" required></div>
            <div><label for="aula">Aula</label><input id="aula" type="text" name="aula" maxlength="20" value="{{ old('aula') }}" required></div>
        </div>
        <div class="form-bottom"><span></span><button type="submit" class="button primary">Guardar docente</button></div>
    </form>
</section>
<section class="card">
    <div class="card-heading"><h2>Directorio de docentes</h2><span class="count">{{ $docentes->count() }} registros</span></div>
    <div class="table-scroll"><table>
        <thead><tr><th>ID</th><th>Nombre</th><th>Especialidad</th><th>Aula</th></tr></thead>
        <tbody>
        @forelse($docentes as $docente)
            <tr><td>{{ $docente->id }}</td><td>{{ $docente->nombre }}</td><td>{{ $docente->especialidad }}</td><td>{{ $docente->aula }}</td></tr>
        @empty
            <tr><td colspan="4" class="empty">No hay registros disponibles.</td></tr>
        @endforelse
        </tbody>
    </table></div>
</section>
@endsection