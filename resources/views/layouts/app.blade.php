<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="theme-color" content="#123b32">
    <title>@yield('titulo', 'Estudiantes') · Gestión Escolar</title>
    <link rel="stylesheet" href="{{ asset('css/app.css') }}">
    <script src="{{ asset('js/app.js') }}" defer></script>
</head>
<body>
<a href="#contenido" class="skip">Ir al contenido</a>
<aside class="sidebar">
    <a class="brand" href="{{ route('estudiantes.index') }}"><span class="brand-icon">G</span><span>Gestión<span class="brand-small">ESCOLAR</span></span></a>
    <p class="nav-label">ADMINISTRACIÓN</p>
    <nav aria-label="Navegación principal">
        <a class="nav-link {{ request()->routeIs('estudiantes.index', 'estudiantes.show', 'estudiantes.edit') ? 'selected' : '' }}" href="{{ route('estudiantes.index') }}"><span aria-hidden="true">▦</span> Estudiantes</a>
        <a class="nav-link {{ request()->routeIs('estudiantes.create') ? 'selected' : '' }}" href="{{ route('estudiantes.create') }}"><span aria-hidden="true">＋</span> Registrar estudiante</a>
    </nav>
    <div class="sidebar-bottom"><span class="status-dot"></span> Gestión académica<p>Programación III · Hito 3</p></div>
</aside>
<div class="workspace">
    <header class="topbar"><span>Panel académico <span class="separator">/</span> <strong>Estudiantes</strong></span><span class="date">{{ now()->format('d/m/Y') }}</span></header>
    <main id="contenido">
        @if(session('exito'))<div class="alert success" role="status">{{ session('exito') }}</div>@endif
        @if($errors->any())
            <div class="alert error" role="alert"><strong>Revisa la información.</strong><ul>@foreach($errors->all() as $error)<li>{{ $error }}</li>@endforeach</ul></div>
        @endif
        @yield('contenido')
    </main>
    <footer class="footer">Gestión Escolar <span>Registro y seguimiento de estudiantes</span></footer>
</div>
</body>
</html>
