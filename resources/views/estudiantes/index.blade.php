@extends('layouts.app')
@section('titulo', 'Estudiantes')
@section('contenido')
<div class="page-heading"><div><p class="eyebrow">COMUNIDAD ACADÉMICA</p><h1>Estudiantes</h1><p class="muted">Toda la información de tus estudiantes, en un solo lugar.</p></div><a class="button primary" href="{{ route('estudiantes.create') }}"><span aria-hidden="true">＋</span> Nuevo estudiante</a></div>
<section class="stats" aria-label="Resumen de estudiantes">
    <article class="stat"><span>Total de estudiantes</span><strong>{{ $resumen['total'] }}</strong><small>Registros en el sistema</small></article>
    <article class="stat"><span><i class="dot green"></i> Activos</span><strong>{{ $resumen['activos'] }}</strong><small>Estudiantes con registro activo</small></article>
    <article class="stat"><span><i class="dot gray"></i> Inactivos</span><strong>{{ $resumen['inactivos'] }}</strong><small>Registros conservados para consulta</small></article>
</section>
<section class="card">
    <div class="card-heading"><h2>Directorio de estudiantes</h2><span class="count">{{ $estudiantes->total() }} resultados</span></div>
    <form method="GET" action="{{ route('estudiantes.index') }}" class="filters" role="search">
        <div class="search-field"><label for="q">Buscar estudiante</label><input id="q" type="search" name="q" value="{{ $busqueda }}" maxlength="100" placeholder="Nombre, apellido, código o correo"></div>
        <div><label for="estado">Estado</label><select name="estado" id="estado"><option value="">Todos los estados</option><option value="activo" @selected($estado === 'activo')>Activo</option><option value="inactivo" @selected($estado === 'inactivo')>Inactivo</option></select></div>
        <button class="button secondary" type="submit">Buscar</button>
        @if($busqueda !== '' || $estado !== '')<a class="text-link clear" href="{{ route('estudiantes.index') }}">Limpiar</a>@endif
    </form>
    <div class="table-scroll"><table><thead><tr><th>Código</th><th>Estudiante</th><th>Contacto</th><th>Estado</th><th class="right">Acciones</th></tr></thead><tbody>
    @forelse($estudiantes as $estudiante)
        <tr><td><span class="code">{{ $estudiante->codigo }}</span></td><td><div class="person"><span class="avatar" aria-hidden="true">{{ mb_substr($estudiante->nombres, 0, 1) }}{{ mb_substr($estudiante->apellidos, 0, 1) }}</span><div><a class="student-name" href="{{ route('estudiantes.show', $estudiante) }}">{{ $estudiante->nombre_completo }}</a><small>Registro #{{ $estudiante->id }}</small></div></div></td><td><span class="email">{{ $estudiante->email }}</span><small>{{ $estudiante->telefono ?: 'Sin teléfono' }}</small></td><td><span class="badge {{ $estudiante->estado }}">{{ ucfirst($estudiante->estado) }}</span></td><td><div class="actions"><a href="{{ route('estudiantes.show', $estudiante) }}" aria-label="Ver a {{ $estudiante->nombre_completo }}">Ver</a><a href="{{ route('estudiantes.edit', $estudiante) }}" aria-label="Editar a {{ $estudiante->nombre_completo }}">Editar</a><form method="POST" action="{{ route('estudiantes.destroy', $estudiante) }}" data-confirm="¿Eliminar a {{ $estudiante->nombre_completo }}? Esta acción no se puede deshacer.">@csrf @method('DELETE')<button class="delete-link" aria-label="Eliminar a {{ $estudiante->nombre_completo }}">Eliminar</button></form></div></td></tr>
    @empty
        <tr><td colspan="5"><div class="empty"><span class="empty-icon" aria-hidden="true">▦</span><h3>{{ $busqueda !== '' || $estado !== '' ? 'No hay coincidencias' : 'Tu directorio está listo para empezar' }}</h3><p>{{ $busqueda !== '' || $estado !== '' ? 'Prueba con otro nombre, código o estado.' : 'Registra al primer estudiante para comenzar.' }}</p><a href="{{ route('estudiantes.create') }}" class="button primary">Registrar estudiante</a></div></td></tr>
    @endforelse
    </tbody></table></div>
    <div class="table-footer"><span>@if($estudiantes->total()) Mostrando {{ $estudiantes->firstItem() }}–{{ $estudiantes->lastItem() }} de {{ $estudiantes->total() }} @else 0 estudiantes @endif</span>
        @if($estudiantes->hasPages())<nav class="pagination" aria-label="Páginas de estudiantes">@if($estudiantes->onFirstPage())<span class="disabled">Anterior</span>@else<a href="{{ $estudiantes->previousPageUrl() }}">Anterior</a>@endif<span>{{ $estudiantes->currentPage() }} / {{ $estudiantes->lastPage() }}</span>@if($estudiantes->hasMorePages())<a href="{{ $estudiantes->nextPageUrl() }}">Siguiente</a>@else<span class="disabled">Siguiente</span>@endif</nav>@endif
    </div>
</section>
@endsection
