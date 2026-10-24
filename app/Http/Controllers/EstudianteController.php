<?php

declare(strict_types=1);

namespace App\Http\Controllers;

use App\Http\Requests\GuardarEstudianteRequest;
use App\Models\Estudiante;
use App\Services\ServicioEstudiantes;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\View\View;
use Illuminate\Validation\Rule;

final class EstudianteController extends Controller
{
    public function __construct(private readonly ServicioEstudiantes $servicio) {}

    public function index(Request $request): View
    {
        $filtros = $request->validate([
            'q' => ['nullable', 'string', 'max:100'],
            'estado' => ['nullable', Rule::in(['activo', 'inactivo'])],
            'page' => ['nullable', 'integer', 'min:1'],
        ]);
        $busqueda = trim($filtros['q'] ?? '');
        $estado = $filtros['estado'] ?? '';
        return view('estudiantes.index', [
            'estudiantes' => $this->servicio->listar($busqueda, $estado),
            'resumen' => $this->servicio->resumen(),
            'busqueda' => $busqueda,
            'estado' => $estado,
        ]);
    }

    public function create(): View
    {
        return view('estudiantes.create', ['estudiante' => new Estudiante(['estado' => 'activo'])]);
    }

    public function store(GuardarEstudianteRequest $request): RedirectResponse
    {
        $estudiante = $this->servicio->crear($request->validated());
        return to_route('estudiantes.show', $estudiante)->with('exito', 'Estudiante registrado correctamente.');
    }

    public function show(Estudiante $estudiante): View
    {
        return view('estudiantes.show', compact('estudiante'));
    }

    public function edit(Estudiante $estudiante): View
    {
        return view('estudiantes.edit', compact('estudiante'));
    }

    public function update(GuardarEstudianteRequest $request, Estudiante $estudiante): RedirectResponse
    {
        $this->servicio->actualizar($estudiante, $request->validated());
        return to_route('estudiantes.show', $estudiante)->with('exito', 'Cambios guardados correctamente.');
    }

    public function destroy(Estudiante $estudiante): RedirectResponse
    {
        $this->servicio->eliminar($estudiante);
        return to_route('estudiantes.index')->with('exito', 'Estudiante eliminado correctamente.');
    }
}
