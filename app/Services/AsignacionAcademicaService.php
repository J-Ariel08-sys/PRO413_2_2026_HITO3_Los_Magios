<?php

declare(strict_types=1);

namespace App\Services;

use App\Models\Estudiante;
use App\Models\Docente;
use App\Models\Calificacion;
use Illuminate\Support\Collection;

class AsignacionAcademicaService
{
    /**
     * Cruza datos de ambas bases de datos y procesa la estructura en memoria.
     */
    public function obtenerReporteGeneral(): Collection
    {
        // 1. Obtener registros e indexar por 'id' en memoria usando Collection (keyBy)
        $estudiantes = Estudiante::all()->keyBy('id'); // BD Docker
        $docentes = Docente::all()->keyBy('id');       // BD Docente
        $calificaciones = Calificacion::all();

        // 2. Transformación de la estructura de datos en PHP usando .map()
        return $calificaciones->map(function ($nota) use ($estudiantes, $docentes) {
            $est = $estudiantes->get($nota->estudiante_id);
            $doc = $docentes->get($nota->docente_id);

            return [
                'estudiante'   => $est ? $est->nombre_completo : 'Desconocido (DB Docker)',
                'materia'      => $nota->asignatura,
                'calificacion' => $nota->nota,
                'docente'      => $doc ? $doc->nombre : 'Sin asignar (DB Docente)',
                'aula'         => $doc ? $doc->aula : 'N/A',
            ];
        });
    }
}