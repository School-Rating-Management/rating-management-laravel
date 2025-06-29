<?php

namespace Tests\Feature\Feature;

use App\Enums\UserRole;
use App\Models\Alumnos;
use App\Models\Ciclos;
use App\Models\Grados;
use App\Models\Grupos;
use App\Models\Materias;
use App\Models\Padres;
use App\Models\Profesores;
use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Tests\TestCase;
use Laravel\Sanctum\Sanctum;

class AlumnoTest extends TestCase
{
    use RefreshDatabase;



    // Test de crear un alumno, ruta: POST            alumnos
    public function test_crear_alumno()
    {

        $user = User::factory()->create(['role' => UserRole::ADMIN]);
        $this->actingAs($user); // Simular autenticación del usuario
        // Sanctum::actingAs($user);
        // Crear un padre y una materia con sus factories
        $padreUser = User::factory()->create(['role' => UserRole::PADRE]);
        $padre = Padres::factory()->create([
            'nombre' => $padreUser->name,
            'apellido' => $padreUser->apellido,
            'correo' => $padreUser->email,
            'user_id' => $padreUser->id
        ]);

        $profesorUser = User::factory()->create(['role' => UserRole::PROFESOR]);
        $profesor = Profesores::factory()->create([
            'nombre' => $profesorUser->name,
            'apellido' => $profesorUser->apellido,
            'user_id' => $profesorUser->id
        ]);

        $materia = Materias::factory()->create();

        $grupo = Grupos::factory()->create([
            'profesor_id' => $profesor->id,
            'grado_id' => Grados::factory()->create()->id,
        ]);

        $ciclo = Ciclos::factory()->create();

        // Enviar solicitud POST para crear un alumno
       $response = $this
            ->post('/alumnos', [
                'nombre' => 'Juan',
                'apellido' => 'Pérez',
                'curp' => 'JUPX890101HDFRRN01',
                'padre_id' => $padre->id,
                'grupo_id' => $grupo->id,
                'ciclo_id' => $ciclo->id,
            ]);

        $response->assertStatus(302);

        // Validar que el registro exista en la base de datos
        $this->assertDatabaseHas('alumnos', [
            'nombre' => 'Juan',
            'apellido' => 'Pérez',
            'curp' => 'JUPX890101HDFRRN01',
            'padre_id' => $padre->id,
            'grupo_id' => $grupo->id,
            'ciclo_id' => $ciclo->id,
        ]);
    }

    // Test de listar alumnos, ruta: GET            alumnos
    public function test_listar_alumnos()
    {
        $user = User::factory()->create(['role' => UserRole::ADMIN]);
        $this->actingAs($user); // Simular autenticación del usuario

        // Crear un alumno con su factory
        $alumno = Alumnos::factory()->create();

        // Enviar solicitud GET para listar alumnos
        $response = $this->get('/alumnos')->assertStatus(200);

    }

    // Test de mostrar un alumno, ruta: GET            alumnos/{id}
    public function test_mostrar_alumno()
    {
        $user = User::factory()->create(['role' => UserRole::ADMIN]);
        $this->actingAs($user); // Simular autenticación del usuario

        $padreUser = User::factory()->create(['role' => UserRole::PADRE]);
        $padre = Padres::factory()->create([
            'nombre' => $padreUser->name,
            'apellido' => $padreUser->apellido,
            'correo' => $padreUser->email,
            'user_id' => $padreUser->id
        ]);

        $profesorUser = User::factory()->create(['role' => UserRole::PROFESOR]);
        $profesor = Profesores::factory()->create([
            'nombre' => $profesorUser->name,
            'apellido' => $profesorUser->apellido,
            'user_id' => $profesorUser->id
        ]);

        $materia = Materias::factory()->create();

        $grupo = Grupos::factory()->create([
            'profesor_id' => $profesor->id,
            'grado_id' => Grados::factory()->create()->id,
        ]);

        $ciclo = Ciclos::factory()->create();

        // Crear un alumno con su factory
            //         'grupo_id' => null,
            // 'padre_id' => null,
            // 'ciclo_id' => null,
        $alumno = Alumnos::factory()->create([
            'nombre' => 'Juan',
            'apellido' => 'Pérez',
            'curp' => 'JUPX890101HDFRRN01',
            'padre_id' => $padre->id,
            'grupo_id' => $grupo->id,
            'ciclo_id' => $ciclo->id,
        ]);

        // Enviar solicitud GET para mostrar un alumno
        $response = $this->get('/alumnos/' . $alumno->id)->assertStatus(200);

    }

    // Test de actualizar un alumno, ruta: PUT/PATCH  alumnos/{id}
    public function test_actualizar_alumno()
    {
        $user = User::factory()->create(['role' => UserRole::ADMIN]);
        $this->actingAs($user); // Simular autenticación del usuario

        $padreUser = User::factory()->create(['role' => UserRole::PADRE]);
        $padre = Padres::factory()->create([
            'nombre' => $padreUser->name,
            'apellido' => $padreUser->apellido,
            'correo' => $padreUser->email,
            'user_id' => $padreUser->id
        ]);

        $profesorUser = User::factory()->create(['role' => UserRole::PROFESOR]);
        $profesor = Profesores::factory()->create([
            'nombre' => $profesorUser->name,
            'apellido' => $profesorUser->apellido,
            'user_id' => $profesorUser->id
        ]);


        $grupo = Grupos::factory()->create([
            'profesor_id' => $profesor->id,
            'grado_id' => Grados::factory()->create()->id,
        ]);

        $ciclo = Ciclos::factory()->create();

        // Crear un alumno con su factory
        $alumno = Alumnos::factory()->create([
            'nombre' => 'Juan',
            'apellido' => 'Pérez',
            'curp' => 'JUPX890101HDFRRN01',
            'padre_id' => $padre->id,
            'grupo_id' => $grupo->id,
            'ciclo_id' => $ciclo->id,
        ]);

        // Enviar solicitud GET para mostrar un alumno
        $response = $this->get('/alumnos/' . $alumno->id)->assertStatus(200);

        // Enviar solicitud PUT/PATCH para actualizar un alumno
        $response = $this->put('/alumnos/' . $alumno->id, [
            'nombre' => 'Juanito',
            'apellido' => 'Pérez',
            'curp' => 'JUPX890101HDFRRN01',
        ]);

        $response->assertStatus(302);

        // Validar que el registro se haya actualizado en la base de datos
        $this->assertDatabaseHas('alumnos', [
            'id' => $alumno->id,
            'nombre' => 'Juanito',
            'apellido' => 'Pérez',
            'curp' => 'JUPX890101HDFRRN01',
        ]);
    }

    // Test de eliminar un alumno, ruta: DELETE      alumnos/{id}
    public function test_desactivar_alumno()
    {
        $user = User::factory()->create(['role' => UserRole::ADMIN]);
        $this->actingAs($user); // Simular autenticación del usuario

        $padreUser = User::factory()->create(['role' => UserRole::PADRE]);
        $padre = Padres::factory()->create([
            'nombre' => $padreUser->name,
            'apellido' => $padreUser->apellido,
            'correo' => $padreUser->email,
            'user_id' => $padreUser->id
        ]);
        $profesorUser = User::factory()->create(['role' => UserRole::PROFESOR]);
        $profesor = Profesores::factory()->create([
            'nombre' => $profesorUser->name,
            'apellido' => $profesorUser->apellido,
            'user_id' => $profesorUser->id
        ]);
        $grupo = Grupos::factory()->create([
            'profesor_id' => $profesor->id,
            'grado_id' => Grados::factory()->create()->id,
        ]);
        $ciclo = Ciclos::factory()->create();

        // Crear un alumno con su factory
        $alumno = Alumnos::factory()->create([
            'nombre' => 'Juan',
            'apellido' => 'Pérez',
            'curp' => 'JUPX890101HDFRRN01',
            'padre_id' => $padre->id,
            'grupo_id' => $grupo->id,
            'ciclo_id' => $ciclo->id,
        ]);
        // Enviar solicitud GET para mostrar un alumno
        $response = $this->get('/alumnos/' . $alumno->id)->assertStatus(200);

        // Enviar solicitud DELETE para eliminar un alumno
        $response = $this->delete('/alumnos/' . $alumno->id);

        $response->assertStatus(302);

        // Validar que el registro no este desactivado en la base de datos
        $this->assertDatabaseMissing('alumnos', [
            'id' => $alumno->id,
            'deleted_at' => null
        ]);
    }

    // Test de elimar permanentemente un alumno
    // ruta: Route::delete('/alumnos/{id}/delete', [AlumnoController::class, 'forceDelete'])->name('alumnos.forceDelete');
    public function test_eliminar_alumno_permanentemente()
    {
        $user = User::factory()->create(['role' => UserRole::ADMIN]);
        $this->actingAs($user); // Simular autenticación del usuario

        $padreUser = User::factory()->create(['role' => UserRole::PADRE]);
        $padre = Padres::factory()->create([
            'nombre' => $padreUser->name,
            'apellido' => $padreUser->apellido,
            'correo' => $padreUser->email,
            'user_id' => $padreUser->id
        ]);
        $profesorUser = User::factory()->create(['role' => UserRole::PROFESOR]);
        $profesor = Profesores::factory()->create([
            'nombre' => $profesorUser->name,
            'apellido' => $profesorUser->apellido,
            'user_id' => $profesorUser->id
        ]);
        $grupo = Grupos::factory()->create([
            'profesor_id' => $profesor->id,
            'grado_id' => Grados::factory()->create()->id,
        ]);
        $ciclo = Ciclos::factory()->create();

        // Crear un alumno con su factory
        $alumno = Alumnos::factory()->create([
            'nombre' => 'Juan',
            'apellido' => 'Pérez',
            'curp' => 'JUPX890101HDFRRN01',
            'padre_id' => $padre->id,
            'grupo_id' => $grupo->id,
            'ciclo_id' => $ciclo->id,
        ]);
        // Enviar solicitud DELETE para eliminar un alumno
        $response = $this->delete('/alumnos/' . $alumno->id);
        $response->assertStatus(302);

        // Enviar solicitud DELETE para eliminar un alumno
        $response = $this->delete('/alumnos/' . $alumno->id . '/delete');

        // Validar que el registro no exista en la base de datos
        $this->assertDatabaseMissing('alumnos', [
            'id' => $alumno->id,
            'deleted_at' => null
        ]);
    }

    public function test_padre_puede_ver_detalle_de_su_hijo()
    {
        $padreUser = User::factory()->create(['role' => UserRole::PADRE]);
        $padre = Padres::factory()->create(['user_id' => $padreUser->id]);

        $alumno = Alumnos::factory()->create(['padre_id' => $padre->id]);

        $this->actingAs($padreUser);

        $response = $this->get("/padre/alumno/{$alumno->id}");

        $response->assertStatus(200);
        $response->assertSee($alumno->nombre);
    }

    public function test_profesor_puede_ver_detalle_de_su_alumno()
    {
        $profesorUser = User::factory()->create(['role' => UserRole::PROFESOR]);
        $profesor = Profesores::factory()->create(['user_id' => $profesorUser->id]);

        $grado = Grados::factory()->create();
        $grupo = Grupos::factory()->create([
            'profesor_id' => $profesor->id,
            'grado_id' => $grado->id,
        ]);
        $alumno = Alumnos::factory()->create(['grupo_id' => $grupo->id]);

        $this->actingAs($profesorUser);

        $response = $this->get("/profesor/alumno/{$alumno->id}");

        $response->assertStatus(200);
        $response->assertSee($alumno->nombre);
    }

    // Test de búsqueda de alumnos
    public function test_buscar_alumno()
    {
        $user = User::factory()->create(['role' => UserRole::ADMIN]);
        $this->actingAs($user); // Simular autenticación del usuario

        $padreUser = User::factory()->create(['role' => UserRole::PADRE]);
        $padre = Padres::factory()->create([
            'nombre' => $padreUser->name,
            'apellido' => $padreUser->apellido,
            'correo' => $padreUser->email,
            'user_id' => $padreUser->id
        ]);
        $profesorUser = User::factory()->create(['role' => UserRole::PROFESOR]);
        $profesor = Profesores::factory()->create([
            'nombre' => $profesorUser->name,
            'apellido' => $profesorUser->apellido,
            'user_id' => $profesorUser->id
        ]);
        $grupo = Grupos::factory()->create([
            'profesor_id' => $profesor->id,
            'grado_id' => Grados::factory()->create()->id,
        ]);
        $ciclo = Ciclos::factory()->create();

        // Crear un alumno con su factory
        $alumno = Alumnos::factory()->create([
            'nombre' => 'Juan',
            'apellido' => 'Pérez',
            'curp' => 'JUPX890101HDFRRN01',
            'padre_id' => $padre->id,
            'grupo_id' => $grupo->id,
            'ciclo_id' => $ciclo->id,
        ]);

        // Enviar solicitud GET para buscar un alumno
        $response = $this->get('/alumnos?search=Juan')->assertStatus(200);

        // Verificar que el alumno esté en la respuesta
        $response->assertSee($alumno->nombre);
    }

    // Test de alumno no encontrado
    public function test_alumno_no_encontrado()
    {
        $user = User::factory()->create(['role' => UserRole::ADMIN]);
        $this->actingAs($user); // Simular autenticación del usuario

        // Enviar solicitud GET para mostrar un alumno que no existe
        $response = $this->get('/alumnos/9999'); // ID que no existe

        $response->assertStatus(404);
    }

    // Test de alumno inactivo
    public function test_alumno_inactivo()
    {
        $user = User::factory()->create(['role' => UserRole::ADMIN]);
        $this->actingAs($user); // Simular autenticación del usuario

        // Crear un alumno inactivo
        $alumno = Alumnos::factory()->create(['deleted_at' => now()]);

        // Enviar solicitud GET para mostrar un alumno inactivo
        // ruta: Route::get('/alumnos/inactivos', [AlumnoController::class, 'inactivos'])->name('alumnos.inactivos');
        $response = $this->get('/alumnos/inactivos');

        // Verificar que el alumno inactivo esté en la respuesta
        $response->assertStatus(200);
        $response->assertSee($alumno->nombre);

    }
}
