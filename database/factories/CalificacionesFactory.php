<?php

namespace Database\Factories;

use App\Models\Calificaciones;
use App\Models\Alumnos;
use App\Models\Materias;
use Illuminate\Database\Eloquent\Factories\Factory;

class CalificacionesFactory extends Factory
{
    protected $model = Calificaciones::class;

    public function definition()
    {
        return [
            'alumno_id' => null,
            'materia_id' => null,
            'calificacion' => $this->faker->randomFloat(1, 5, 10),
            'fecha' => $this->faker->date(),
        ];
    }
}
