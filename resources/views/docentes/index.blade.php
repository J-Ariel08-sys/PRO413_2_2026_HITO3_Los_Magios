<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <title>Módulo Docentes - Red Local</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
</head>
<body class="container mt-5">
    <h2>Módulo Académico - Servidor Docente (Red Local)</h2>

    @php($errorRed = $errorRed ?? session('errorRed'))
    @if($errorRed)
        <div class="alert alert-danger" role="alert">
            {{ $errorRed }}
        </div>
    @endif

    @if($errors->any())
        <div class="alert alert-warning" role="alert">
            <ul class="mb-0">@foreach($errors->all() as $error)<li>{{ $error }}</li>@endforeach</ul>
        </div>
    @endif

    <p><a href="{{ route('estudiantes.index') }}">&larr; Volver a Estudiantes</a></p>

    @if(session('success'))
        <div class="alert alert-success">
            {{ session('success') }}
        </div>
    @endif

    <div class="card mb-4">
        <div class="card-header">Registrar Nuevo Docente</div>
        <div class="card-body">
            <form action="{{ route('docentes.store') }}" method="POST">
                @csrf
                <div class="mb-3">
                    <label class="form-label">Nombre</label>
                    <input type="text" name="nombre" class="form-control" required>
                </div>
                <div class="mb-3">
                    <label class="form-label">Especialidad</label>
                    <input type="text" name="especialidad" class="form-control" required>
                </div>
                <div class="mb-3">
                    <label class="form-label">Aula</label>
                    <input type="text" name="aula" class="form-control" required>
                </div>
                <button type="submit" class="btn btn-primary">Guardar en Servidor Docente</button>
            </form>
        </div>
    </div>

    <h3>Lista de Docentes (Red Local)</h3>
    <table class="table table-bordered">
        <thead>
            <tr>
                <th>ID</th>
                <th>Nombre</th>
                <th>Especialidad</th>
                <th>Aula</th>
            </tr>
        </thead>
        <tbody>
            @forelse($docentes as $docente)
                <tr>
                    <td>{{ $docente->id }}</td>
                    <td>{{ $docente->nombre }}</td>
                    <td>{{ $docente->especialidad }}</td>
                    <td>{{ $docente->aula }}</td>
                </tr>
            @empty
                <tr>
                    <td colspan="4" class="text-center">No hay registros disponibles o el servidor está desconectado.</td>
                </tr>
            @endforelse
        </tbody>
    </table>
</body>
</html>