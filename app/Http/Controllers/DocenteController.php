<?php
declare(strict_types=1);

namespace App\Http\Controllers;

use App\Models\Docente;
use Illuminate\Http\Request;
use PDOException;

class DocenteController extends Controller
{
    /**
     * Muestra la lista de docentes consultando la base de datos de la red local.
     */
    public function index()
    {
        try {
            // Intentar consultar la base de datos externa del docente
            $docentes = Docente::all();
            return view('docentes.index', compact('docentes'))->with('errorRed', null);

        } catch (PDOException $e) {
            // Capturar la caída de red o bloqueo del servidor docente
            $docentes = collect(); // Colección vacía para que la vista no explote
            $mensajeError = "Advertencia: No se pudo establecer conexión con el servidor del docente en la red local. Verifique su conexión de red.";
            
            return view('docentes.index', compact('docentes'))->with('errorRed', $mensajeError);
        }
    }

    /**
     * Almacena un nuevo docente en la base de datos local del docente.
     */
    public function store(Request $request)
    {
        $request->validate([
            'nombre' => 'required|string|max:100',
            'especialidad' => 'required|string|max:100',
            'aula' => 'required|string|max:20',
        ]);

        try {
            Docente::create($request->only(['nombre', 'especialidad', 'aula']));
            return redirect()->route('docentes.index')->with('success', 'Docente registrado correctamente en la red local.');

        } catch (PDOException $e) {
            return redirect()->route('docentes.index')->with('errorRed', 'Error crítico: No se pudo guardar el registro porque el servidor docente no responde.');
        }
    }
}