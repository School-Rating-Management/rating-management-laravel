<?php

namespace Database\Factories;

use App\Models\Ciclos;
use Illuminate\Database\Eloquent\Factories\Factory;

class CiclosFactory extends Factory
{
    protected $model = Ciclos::class;

    public function definition()
    {
        return [
            'nombre' => $this->faker->unique()->year() . '-' . ($this->faker->year() + 1),
        ];
    }
}
