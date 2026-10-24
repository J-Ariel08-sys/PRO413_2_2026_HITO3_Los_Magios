<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Los Magios - Reporte Consolidado</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
</head>
<body class="bg-light p-4">
    <div class="container">
        <h2 class="mb-4 text-center">Reporte Consolidado (Grupo: Los Magios)</h2>

        <div class="card shadow">
            <div class="card-header bg-primary text-white">
                <h5 class="mb-0">Resultados Académicos Cruzados en Memoria PHP</h5>
            </div>
            <div class="card-body">
                <table class="table table-bordered table-striped align-middle">
                    <thead class="table-dark">
                        <tr>
                            <th>Estudiante (BD Docker)</th>
                            <th>Asignatura</th>
                            <th>Nota</th>
                            <th>Docente (BD Docente)</th>
                            <th>Aula (BD Docente)</th>
                        </tr>
                    </thead>
                    <tbody>
                        @forelse($reporte as $item)
                            <tr>
                                <td>{{ $item['estudiante'] }}</td>
                                <td>{{ $item['materia'] }}</td>
                                <td>
                                    <span class="badge {{ $item['calificacion'] >= 51 ? 'bg-success' : 'bg-danger' }}">
                                        {{ $item['calificacion'] }}
                                    </span>
                                </td>
                                <td>{{ $item['docente'] }}</td>
                                <td><span class="badge bg-secondary">{{ $item['aula'] }}</span></td>
                            </tr>
                        @empty
                            <tr>
                                <td colspan="5" class="text-center text-muted">No hay datos registrados.</td>
                            </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>
        </div>
    </div>
</body>
</html>