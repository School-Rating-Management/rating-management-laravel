<?php

namespace Tests\Feature\Feature;

use App\Models\Alumnos;
use App\Models\Materias;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Tests\TestCase;

class CalificacionTest extends TestCase
{
    // public function test_asignar_calificacion()
    // {
    //     $alumno = Alumnos::factory()->create();
    //     $materia = Materias::factory()->create();

    //     $response = $this->postJson('/api/calificaciones', [
    //         'alumno_id' => $alumno->id,
    //         'materia_id' => $materia->id,
    //         'calificacion' => 8.5
    //     ]);

    //     $response->assertStatus(201)
    //             ->assertJsonFragment(['calificacion' => 8.5]);

    //     $this->assertDatabaseHas('calificaciones', [
    //         'alumno_id' => $alumno->id,
    //         'materia_id' => $materia->id,
    //         'calificacion' => 8.5
    //     ]);
    // }

}
