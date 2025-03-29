<?php

namespace Database\Factories;

use App\Models\Grados;
use Illuminate\Database\Eloquent\Factories\Factory;

class GradosFactory extends Factory
{
    protected $model = Grados::class;

    public function definition()
    {
        return [
            'nombre_grado' => $this->faker->randomElement(['1°', '2°', '3°', '4°', '5°', '6°']),
        ];
    }
}
