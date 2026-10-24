<?php

declare(strict_types=1);

namespace App\Http\Controllers;

use App\Services\AsignacionAcademicaService;
use Illuminate\View\View;

class ReporteController extends Controller
{
    public function index(AsignacionAcademicaService $service): View
    {
        $reporte = $service->obtenerReporteGeneral();
        return view('reporte-consolidado', compact('reporte'));
    }
}