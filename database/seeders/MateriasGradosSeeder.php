<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\Grados;
use App\Models\Materias;

class MateriasGradosSeeder extends Seeder
{
    public function run(): void
    {
        $grados = Grados::all();
        $materias = Materias::all();

        foreach ($grados as $grado) {
            $grado->materias()->attach(
                $materias->random(rand(2, 4))->pluck('id')->toArray()
            );
        }
    }
}
