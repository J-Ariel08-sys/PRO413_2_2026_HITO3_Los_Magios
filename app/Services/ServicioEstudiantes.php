<?php

declare(strict_types=1);

namespace App\Services;

use App\Contracts\RepositorioEstudiantes;
use App\Models\Estudiante;
use Illuminate\Contracts\Pagination\LengthAwarePaginator;

final class ServicioEstudiantes
{
    public function __construct(private readonly RepositorioEstudiantes $repositorio) {}

    public function listar(string $busqueda, string $estado): LengthAwarePaginator
    {
        return $this->repositorio->listar($busqueda, $estado);
    }

    public function resumen(): array
    {
        // Collection -> arreglo asociativo que organiza los indicadores antes del HTML.
        $conteos = $this->repositorio->contarPorEstado();
        return [
            'total' => (int) $conteos->sum(),
            'activos' => (int) $conteos->get('activo', 0),
            'inactivos' => (int) $conteos->get('inactivo', 0),
        ];
    }

    public function crear(array $datos): Estudiante
    {
        return $this->repositorio->crear($datos);
    }

    public function actualizar(Estudiante $estudiante, array $datos): void
    {
        $this->repositorio->actualizar($estudiante, $datos);
    }

    public function eliminar(Estudiante $estudiante): void
    {
        $this->repositorio->eliminar($estudiante);
    }
}
