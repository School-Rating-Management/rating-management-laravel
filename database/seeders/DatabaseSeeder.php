<?php
namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\Grupos;
use App\Models\Padres;
use App\Models\Ciclos;
use App\Models\Grados;
use App\Models\Materias;
use App\Models\Alumnos;
use App\Models\Calificaciones;
use App\Models\HistorialAlumnos;
use App\Models\Profesores;
use App\Models\User;

class DatabaseSeeder extends Seeder
{
    protected $ciclosSeeder = [
        '2023-2024',
        '2024-2025',
        '2025-2026',
    ];
    protected $gradosSeeder = [
        'Primero',
        'Segundo',
        'Tercero',
        'Cuarto',
        'Quinto',
        'Sexto',
    ];
    protected $materiasSeeder = [
        'Matemáticas',
        'Español',
        'Ciencias Naturales',
        'Historia',
        'Geografía',
    ];
    protected $gruposSeeder = [
        'A',
        'B',
        'C',
    ];

    public function run(): void
    {
        // 1. Crear Ciclos
        foreach ($this->ciclosSeeder as $ciclo) {
            Ciclos::factory()->create(['nombre' => $ciclo]);
        }
        $ciclos = Ciclos::all();

        // 2. Crear Users y Profesores sincronizados
        $usersProfesores = User::factory(5)->create(['role' => 'profesor']);
        $profesores = collect();
        foreach ($usersProfesores as $user) {
            $profesor = Profesores::factory()->create([
                'user_id' => $user->id,
                'nombre' => $user->name,
                'apellido' => fake()->lastName(),
            ]);
            $profesores->push($profesor);
        }

        // 3. Crear Grados
        foreach ($this->gradosSeeder as $grado) {
            Grados::factory()->create(['nombre_grado' => $grado]);
        }
        $grados = Grados::all();

        // 4. Crear Grupos y asignar profesor y grado
        $profesorIndex = 0;
        foreach ($this->gruposSeeder as $grupo) {
            Grupos::factory()->create([
                'nombre_grupo' => $grupo,
                'profesor_id' => $profesores[$profesorIndex]->id,  // Asignar un profesor único
                'grado_id' => $grados->random()->id,
            ]);
            $profesorIndex++;  // Aumentar el índice para asignar un profesor diferente en el siguiente grupo
        }
        $grupos = Grupos::all();

        // 5. Crear Materias
        foreach ($this->materiasSeeder as $materia) {
            Materias::factory()->create(['nombre_materia' => $materia]);
        }
        $materias = Materias::all();

        // 6. Crear Users y Padres sincronizados
        $usersPadres = User::factory(5)->create(['role' => 'padre']);
        $padres = collect();
        foreach ($usersPadres as $user) {
            $padre = Padres::factory()->create([
                'user_id' => $user->id,
                'nombre' => $user->name,
                'apellido' => fake()->lastName(),
            ]);
            $padres->push($padre);
        }

        // 7. Crear Alumnos con padre aleatorio y grupo/ciclo aleatorio
        $alumnos = collect();
        foreach (range(1, 10) as $i) {
            $padre = $padres->random();
            $alumno = Alumnos::factory()->create([
                'padre_id' => $padre->id,
                'ciclo_id' => $ciclos->random()->id,
                'grupo_id' => $grupos->random()->id,
            ]);
            $alumnos->push($alumno);
        }

        // 8. Crear Calificaciones e Historial
        foreach ($alumnos as $alumno) {
            foreach ($materias as $materia) {
                Calificaciones::factory()->create([
                    'alumno_id' => $alumno->id,
                    'materia_id' => $materia->id,
                ]);

                HistorialAlumnos::factory()->create([
                    'alumno_id' => $alumno->id,
                    'ciclo_id' => $alumno->ciclo_id,
                    'grado_id' => $grados->random()->id,
                    'grupo_id' => $alumno->grupo_id,
                    'materia_id' => $materia->id,
                ]);
            }
        }

        $this->command->info('✅ Datos insertados correctamente con relaciones sincronizadas.');
    }
}
