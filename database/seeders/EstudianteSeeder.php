<?php

declare(strict_types=1);

namespace Database\Seeders;

use App\Models\Estudiante;
use Illuminate\Database\Seeder;

class EstudianteSeeder extends Seeder
{
    public function run(): void
    {
        $ejemplos = [
            ['codigo' => 'EST-001', 'nombres' => 'Ana', 'apellidos' => 'Quispe', 'email' => 'ana@example.com', 'telefono' => '70000001', 'fecha_nacimiento' => '2004-03-14', 'estado' => 'activo'],
            ['codigo' => 'EST-002', 'nombres' => 'Luis', 'apellidos' => 'Mamani', 'email' => 'luis@example.com', 'telefono' => '70000002', 'fecha_nacimiento' => '2003-11-06', 'estado' => 'activo'],
            ['codigo' => 'EST-003', 'nombres' => 'Carla', 'apellidos' => 'Flores', 'email' => 'carla@example.com', 'telefono' => null, 'fecha_nacimiento' => '2004-08-22', 'estado' => 'inactivo'],
        ];
        foreach ($ejemplos as $datos) {
            // Repetir el seeder no duplica ni sobreescribe registros existentes.
            Estudiante::firstOrCreate(['codigo' => $datos['codigo']], $datos);
        }
    }
}
