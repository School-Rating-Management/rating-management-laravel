<?php

namespace Database\Factories;

use App\Models\Padres;
use App\Models\User;
use Illuminate\Database\Eloquent\Factories\Factory;

class PadresFactory extends Factory
{
    protected $model = Padres::class;

    public function definition()
    {
        return [
            'nombre' => $this->faker->firstName,
            'apellido' => $this->faker->lastName,
            'telefono' => $this->faker->phoneNumber,
            'correo' => $this->faker->unique()->safeEmail,
            'user_id' => null,
        ];
    }
}
