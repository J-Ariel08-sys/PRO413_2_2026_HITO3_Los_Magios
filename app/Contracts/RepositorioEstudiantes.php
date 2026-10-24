<?php

declare(strict_types=1);

namespace App\Contracts;

use App\Models\Estudiante;
use Illuminate\Contracts\Pagination\LengthAwarePaginator;
use Illuminate\Support\Collection;

interface RepositorioEstudiantes
{
    public function listar(string $busqueda, string $estado): LengthAwarePaginator;
    public function contarPorEstado(): Collection;
    public function crear(array $datos): Estudiante;
    public function actualizar(Estudiante $estudiante, array $datos): void;
    public function eliminar(Estudiante $estudiante): void;
}
