<?php

namespace Database\Factories;

use App\Models\Alumnos;
use App\Models\Grupos;
use App\Models\Padres;
use App\Models\Ciclos;
use Illuminate\Database\Eloquent\Factories\Factory;

class AlumnosFactory extends Factory
{
    protected $model = Alumnos::class;

    public function definition()
    {
        return [
            'nombre' => $this->faker->firstName,
            'apellido' => $this->faker->lastName,
            'curp' => strtoupper($this->faker->bothify('????######??????')),
            'grupo_id' => null,
            'padre_id' => null,
            'ciclo_id' => null,
        ];
    }
}
