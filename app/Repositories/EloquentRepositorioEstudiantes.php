<?php

declare(strict_types=1);

namespace App\Repositories;

use App\Contracts\RepositorioEstudiantes;
use App\Models\Estudiante;
use Illuminate\Contracts\Pagination\LengthAwarePaginator;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Support\Collection;

final class EloquentRepositorioEstudiantes implements RepositorioEstudiantes
{
    public function listar(string $busqueda, string $estado): LengthAwarePaginator
    {
        return Estudiante::query()
            ->when($busqueda !== '', function (Builder $query) use ($busqueda): void {
                // Eloquent utiliza parámetros; nunca se concatena SQL del usuario.
                $query->where(function (Builder $q) use ($busqueda): void {
                    $q->where('codigo', 'like', '%'.$busqueda.'%')
                        ->orWhere('nombres', 'like', '%'.$busqueda.'%')
                        ->orWhere('apellidos', 'like', '%'.$busqueda.'%')
                        ->orWhere('email', 'like', '%'.$busqueda.'%');
                });
            })
            ->when($estado !== '', fn (Builder $q): Builder => $q->where('estado', $estado))
            ->orderBy('apellidos')->orderBy('nombres')->orderBy('id')
            ->paginate(10)->withQueryString();
    }

    public function contarPorEstado(): Collection
    {
        return Estudiante::query()->selectRaw('estado, COUNT(*) AS cantidad')
            ->groupBy('estado')->pluck('cantidad', 'estado')
            ->map(fn ($cantidad): int => (int) $cantidad);
    }

    public function crear(array $datos): Estudiante
    {
        return Estudiante::create($datos);
    }

    public function actualizar(Estudiante $estudiante, array $datos): void
    {
        $estudiante->update($datos);
    }

    public function eliminar(Estudiante $estudiante): void
    {
        // La futura FK de inscripciones debe usar RESTRICT para proteger el historial.
        $estudiante->delete();
    }
}
