<?php

declare(strict_types=1);

namespace Tests\Feature;

use App\Contracts\RepositorioEstudiantes;
use App\Models\Estudiante;
use Database\Seeders\EstudianteSeeder;
use Illuminate\Database\QueryException;
use Illuminate\Foundation\Testing\RefreshDatabase;
use PHPUnit\Framework\Attributes\DataProvider;
use Tests\TestCase;

class EstudiantesTest extends TestCase
{
    use RefreshDatabase;

    private function datos(array $cambios = []): array
    {
        return array_merge([
            'codigo' => 'PR-001', 'nombres' => 'María', 'apellidos' => 'Pérez',
            'email' => 'maria@example.com', 'telefono' => '70000004',
            'fecha_nacimiento' => '2004-02-29', 'estado' => 'activo',
        ], $cambios);
    }

    public function test_ciclo_completo_crear_consultar_editar_eliminar(): void
    {
        $this->get('/')->assertRedirect('/estudiantes');
        $this->get('/estudiantes')->assertOk()->assertSee('Tu directorio está listo');
        $this->get('/estudiantes/create')->assertOk();
        $this->post('/estudiantes', $this->datos())->assertSessionHasNoErrors()->assertRedirect();
        $estudiante = Estudiante::firstOrFail();
        $this->assertDatabaseHas('estudiantes', ['codigo' => 'PR-001']);
        $this->get('/estudiantes/'.$estudiante->id)->assertOk()->assertSee('María Pérez');
        $this->get('/estudiantes/'.$estudiante->id.'/edit')->assertOk()->assertSee('PR-001');
        $this->put('/estudiantes/'.$estudiante->id, $this->datos(['nombres' => 'María Elena', 'estado' => 'inactivo']))
            ->assertSessionHasNoErrors()->assertRedirect();
        $this->assertDatabaseHas('estudiantes', ['id' => $estudiante->id, 'nombres' => 'María Elena', 'estado' => 'inactivo']);
        $this->delete('/estudiantes/'.$estudiante->id)->assertRedirect('/estudiantes');
        $this->assertDatabaseMissing('estudiantes', ['id' => $estudiante->id]);
    }

    public function test_normaliza_y_admite_campos_opcionales(): void
    {
        $this->post('/estudiantes', $this->datos(['codigo' => ' pr-010 ', 'email' => ' MARIA@EXAMPLE.COM ', 'telefono' => '', 'fecha_nacimiento' => '']))->assertSessionHasNoErrors();
        $this->assertDatabaseHas('estudiantes', ['codigo' => 'PR-010', 'email' => 'maria@example.com', 'telefono' => null, 'fecha_nacimiento' => null]);
    }

    public function test_rechaza_duplicados_en_creacion_y_actualizacion(): void
    {
        Estudiante::create($this->datos());
        $dos = Estudiante::create($this->datos(['codigo' => 'PR-002', 'email' => 'dos@example.com']));
        $this->post('/estudiantes', $this->datos())->assertSessionHasErrors(['codigo', 'email']);
        $this->put('/estudiantes/'.$dos->id, $this->datos())->assertSessionHasErrors(['codigo', 'email']);
        $this->assertDatabaseCount('estudiantes', 2);
        $this->assertSame('PR-002', $dos->fresh()->codigo);
    }

    #[DataProvider('datosInvalidos')]
    public function test_rechaza_datos_invalidos_sin_persistir(array $cambios, string $campo): void
    {
        $this->from('/estudiantes/create')->post('/estudiantes', $this->datos($cambios))
            ->assertRedirect('/estudiantes/create')->assertSessionHasErrors($campo);
        $this->assertDatabaseCount('estudiantes', 0);
    }

    public static function datosInvalidos(): array
    {
        return [
            'codigo obligatorio' => [['codigo' => ''], 'codigo'],
            'nombre obligatorio' => [['nombres' => '   '], 'nombres'],
            'apellido obligatorio' => [['apellidos' => ''], 'apellidos'],
            'correo inválido' => [['email' => 'no-es-correo'], 'email'],
            'código inválido' => [['codigo' => 'ABC/10'], 'codigo'],
            'código demasiado largo' => [['codigo' => str_repeat('A', 21)], 'codigo'],
            'estado inválido' => [['estado' => 'desconocido'], 'estado'],
            'fecha futura' => [['fecha_nacimiento' => '2999-01-01'], 'fecha_nacimiento'],
            'fecha imposible' => [['fecha_nacimiento' => '2004-02-31'], 'fecha_nacimiento'],
            'fecha antigua' => [['fecha_nacimiento' => '1800-01-01'], 'fecha_nacimiento'],
            'teléfono inválido' => [['telefono' => 'abcd'], 'telefono'],
            'arreglo en vez de texto' => [['nombres' => ['dato']], 'nombres'],
        ];
    }

    public function test_busqueda_estado_paginacion_y_resumen(): void
    {
        for ($i = 1; $i <= 13; $i++) {
            Estudiante::create($this->datos(['codigo' => 'LIST-'.$i, 'nombres' => 'Persona '.$i, 'email' => 'persona'.$i.'@example.com']));
        }
        Estudiante::create($this->datos(['codigo' => 'INACTIVO', 'nombres' => 'Sofía', 'email' => 'sofia@example.com', 'estado' => 'inactivo']));
        $this->get('/estudiantes')->assertOk()->assertViewHas('resumen', ['total' => 14, 'activos' => 13, 'inactivos' => 1])
            ->assertViewHas('estudiantes', fn ($lista): bool => $lista->count() === 10);
        $this->get('/estudiantes?page=2')->assertOk()->assertViewHas('estudiantes', fn ($lista): bool => $lista->count() === 4);
        $this->get('/estudiantes?estado=inactivo')->assertOk()->assertSee('Sofía')->assertDontSee('Persona 1');
        $this->get('/estudiantes?q=INACTIVO')->assertOk()->assertSee('Sofía')->assertDontSee('Persona 1');
        $this->get('/estudiantes?q=INACTIVO&estado=activo')->assertOk()->assertSee('No hay coincidencias');
    }

    public function test_registro_inexistente_devuelve_404(): void
    {
        $this->get('/estudiantes/999999')->assertNotFound()->assertSee('Registro no encontrado');
        $this->put('/estudiantes/999999', $this->datos())->assertNotFound();
        $this->delete('/estudiantes/999999')->assertNotFound();
    }

    public function test_html_del_usuario_se_muestra_como_texto(): void
    {
        $estudiante = Estudiante::create($this->datos(['nombres' => '<script>alert(1)</script>']));
        $this->get('/estudiantes/'.$estudiante->id)->assertOk()
            ->assertDontSee('<script>alert(1)</script>', false)->assertSee('&lt;script&gt;', false);
    }

    public function test_seeder_repetible_sin_duplicados(): void
    {
        $this->seed(EstudianteSeeder::class);
        $this->seed(EstudianteSeeder::class);
        $this->assertDatabaseCount('estudiantes', 3);
    }

    public function test_error_de_base_no_expone_sql_ni_credenciales(): void
    {
        $repositorio = \Mockery::mock(RepositorioEstudiantes::class);
        $repositorio->shouldReceive('listar')->andThrow(new QueryException('mysql', 'select * from tabla_secreta', [], new \PDOException('clave_super_secreta')));
        $this->app->instance(RepositorioEstudiantes::class, $repositorio);
        $this->get('/estudiantes')->assertStatus(503)->assertSee('No se pudo acceder a la base de datos')
            ->assertDontSee('tabla_secreta')->assertDontSee('clave_super_secreta');
    }
}
