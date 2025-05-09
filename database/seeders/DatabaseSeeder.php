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
use App\Models\MateriasGrados;
use App\Models\Profesores;
use App\Models\User;

class DatabaseSeeder extends Seeder
{
    protected $ciclosSeeder = [
        '2023-2024',
        '2024-2025',
        '2025-2026',
        '2026-2027',
        '2027-2028',
        '2028-2029',
        '2029-2030',
        '2030-2031',
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
        /*
        RESTRICCIONES:
        - Un padre puede tener varios alumnos, pero un alumno solo puede tener un padre.
        - Un alumno puede estar en un solo grupo y ciclo, pero un grupo puede tener varios alumnos.
        - Un ciclo puede tener varios alumnos, pero un alumno solo puede estar en un ciclo.
        - Un grupo puede tener varios alumnos, pero un alumno solo puede estar en un grupo.
        - Un profesor puede tener varios grupos, pero un grupo solo puede tener un profesor.
        - Un grado puede tener varios grupos, pero un grupo solo puede tener un grado.

        RELACIONES:
        - Un grupo tiene un profesor.
        - Un grupo tiene un grado en la tabla grado_grupo
        */
        // Crear ciclos
        foreach ($this->ciclosSeeder as $ciclo) {
            Ciclos::create([
                'nombre' => $ciclo,
            ]);
        }
        $ciclos = Ciclos::all();
        if($ciclos->isEmpty()){
            $this->command->info('❌ No se han creado ciclos.');
            return;
        }
        $this->command->info('✅ Ciclos creados: ' . $ciclos->count());

        // Crear grados
        foreach ($this->gradosSeeder as $grado) {
            Grados::create([
                'nombre_grado' => $grado,
            ]);
        }
        $grados = Grados::all();
        if($grados->isEmpty()){
            $this->command->info('❌ No se han creado grados.');
            return;
        }
        $this->command->info('✅ Grados creados: ' . $grados->count());

        // Crear materias y asignar la relacion de la materia a un grado
        foreach ($this->materiasSeeder as $materia) {
            $materia = Materias::create([
                'nombre_materia' => $materia,
            ]);
            // Asignar la materia a un grado
            foreach ($this->gradosSeeder as $grado) {
                $grado = Grados::where('nombre_grado', $grado)->first();
                MateriasGrados::create([
                    'materia_id' => $materia->id,
                    'grado_id' => $grado->id,
                ]);
            }
        }
        $materias = Materias::all();
        if($materias->isEmpty()){
            $this->command->info('❌ No se han creado materias.');
            return;
        }
        $this->command->info('✅ Materias creadas: ' . $materias->count());

        // Crear usuarios con rol de admin
        User::factory(1)->create([
            'role' => 'admin',
        ])->each(function ($user) {
            $user->update([
                'name' => 'Admin',
                'apellido' => 'Admin',
                'email' => 'admin@gmail.com',
                'password' => bcrypt('admin123'),
            ]);
        });
        $admin = User::where('role', 'admin')->first();
        if(is_null($admin)){
            $this->command->info('❌ No se ha creado el admin.');
            return;
        }
        // Crear usuarios con rol de profesor
        User::factory(18)->create([
            'role' => 'profesor',
        ])->each(function ($user) {
            Profesores::factory()->create([
                'nombre' => $user->name,
                'apellido' => $user->apellido,
                'user_id' => $user->id,
            ]);
        });
        $profesores = Profesores::all();
        if($profesores->isEmpty()){
            $this->command->info('❌ No se han creado profesores.');
            return;
        }
        $this->command->info('✅ Profesores creados: ' . $profesores->count());

        // Crear grupos por cada grado y con un profesor unico, luego asignar la relacion de grupo y grado a la tabla grado_grupo
        $profesorIndex = 0;
        foreach ($this->gradosSeeder as $grado) {
            foreach ($this->gruposSeeder as $grupo) {
                // profesor unico por grupo
                $profesor = $profesores[$profesorIndex];
                $profesorIndex++;
                $grupo = Grupos::create([
                    'nombre_grupo' => $grado . '-' . $grupo,
                    'profesor_id' => $profesor->id,
                    'grado_id' => Grados::where('nombre_grado', $grado)->first()->id,
                ]);
            }
        }
        $grupos = Grupos::all();
        if($grupos->isEmpty()){
            $this->command->info('❌ No se han creado grupos.');
            return;
        }
        $this->command->info('✅ Grupos creados: ' . $grupos->count());

        // Crear padres
        User::factory(100)->create([
            'role' => 'padre',
        ])->each(function ($user) {
            Padres::factory()->create([
                'nombre' => $user->name,
                'apellido' => $user->apellido,
                'correo' => $user->email,
                'user_id' => $user->id,
            ]);
        });
        $padres = Padres::all();
        if($padres->isEmpty()){
            $this->command->info('❌ No se han creado padres.');
            return;
        }
        $this->command->info('✅ Padres creados: ' . $padres->count());

        $padreIndex = 0;
        $padresCount = $padres->count();
        // Crear alumnos y asignarles un padre, un grupo y un ciclo, todos unicos
        foreach ($this->gradosSeeder as $grado) {
            foreach ($this->gruposSeeder as $grupo) {
                foreach ($this->ciclosSeeder as $ciclo) {
                                // Obtener padre de la lista secuencialmente
                    if($padreIndex >= $padresCount){
                        $padreIndex = 0;
                    }
                    $padre = $padres[$padreIndex];

                    $alumno = Alumnos::factory()->create([
                        'grupo_id' => Grupos::where('nombre_grupo', $grado . '-' . $grupo)->first()->id,
                        'padre_id' => $padre->id,
                        'ciclo_id' => Ciclos::where('nombre', $ciclo)->first()->id,
                    ]);
                    $padreIndex++;
                    // Crear calificaciones y asignarles un alumno, una materia.
                    foreach ($this->materiasSeeder as $materia) {
                        Calificaciones::factory()->create([
                            'alumno_id' => $alumno->id,
                            'materia_id' => Materias::where('nombre_materia', $materia)->first()->id,
                        ]);
                    }
                    // revisar que el alumno si tenga calificaciones
                    $calificaciones = Calificaciones::where('alumno_id', $alumno->id)->get();
                    if($calificaciones->isEmpty()){
                        $this->command->info('❌ No se han creado calificaciones para el alumno: ' . $alumno->nombre . ' ' . $alumno->apellido);
                        return;
                    }
                }
            }
        }


        $alumnos = Alumnos::all();
        if($alumnos->isEmpty()){
            $this->command->info('❌ No se han creado alumnos.');
            return;
        }
        $this->command->info('✅ Alumnos creados: ' . $alumnos->count());


        // // Un alumno puede tener varias calificaciones, pero una calificacion solo puede tener un alumno y una materia.
        // foreach ($this->gradosSeeder as $grado) {
        //     foreach ($this->materiasSeeder as $materia) {
        //         $alumnos = Alumnos::whereHas('grupo.grados', function ($query) use ($grado) {
        //             $query->where('nombre', $grado);
        //         })->get();
        //         foreach ($alumnos as $alumno) {
        //             Calificaciones::factory()->create([
        //                 'alumno_id' => $alumno->id,
        //                 'materia_id' => Materias::where('nombre', $materia)->first()->id,
        //             ]);
        //         }
        //     }
        // }
        $calificaciones = Calificaciones::all();
        if($calificaciones->isEmpty()){
            $this->command->info('❌ No se han creado calificaciones.');
            return;
        }
        $this->command->info('✅ Calificaciones creadas: ' . $calificaciones->count());

        $this->command->info('Base de datos inicializada con datos de prueba.');


    }
}
