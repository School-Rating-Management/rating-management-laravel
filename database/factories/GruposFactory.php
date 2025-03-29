<?php

namespace Database\Factories;

use App\Models\Grupos;
use App\Models\Profesores;
use App\Models\Grados;
use Illuminate\Database\Eloquent\Factories\Factory;

class GruposFactory extends Factory
{
    protected $model = Grupos::class;

    public function definition()
    {
        return [
            'nombre_grupo' => $this->faker->randomLetter . $this->faker->randomDigit,
            'profesor_id' => null,
            'grado_id' => null,
        ];
    }
}
