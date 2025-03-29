<?php

namespace Database\Factories;

use App\Models\Materias;
use Illuminate\Database\Eloquent\Factories\Factory;

class MateriasFactory extends Factory
{
    protected $model = Materias::class;



    public function definition()
    {

        return [
            'nombre_materia' => $this->faker->unique()->word,
        ];
    }
}
