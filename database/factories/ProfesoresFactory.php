<?php

namespace Database\Factories;

use App\Models\Profesores;
use App\Models\User;
use Illuminate\Database\Eloquent\Factories\Factory;

class ProfesoresFactory extends Factory
{
    protected $model = Profesores::class;

    public function definition()
    {
        return [
            'nombre' => $this->faker->firstName,
            'apellido' => $this->faker->lastName,
            'user_id' => null,
        ];
    }
}
