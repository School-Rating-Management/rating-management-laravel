<?php

namespace Database\Factories;

use App\Models\HistorialAlumnos;
use App\Models\Alumnos;
use App\Models\Ciclos;
use App\Models\Grados;
use App\Models\Grupos;
use App\Models\Materias;
use Illuminate\Database\Eloquent\Factories\Factory;

class HistorialAlumnosFactory extends Factory
{
    protected $model = HistorialAlumnos::class;

    public function definition()
    {
        return [
            'alumno_id' => null,
            'ciclo_id' => null,
            'grado_id' => null,
            'grupo_id' => null,
            'materia_id' => null,
            'calificacion' => $this->faker->randomFloat(1, 5, 10),
            'fecha_calificacion' => $this->faker->date(),
            'fecha_cambio' => $this->faker->date(),
        ];
    }
}
