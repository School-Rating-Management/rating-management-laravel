<?php

namespace Tests\Feature\Feature;

use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Tests\TestCase;

class ProfesorTest extends TestCase
{

    // public function test_crear_profesor()
    // {
    //     $user = User::factory()->create(['role' => 'PROFESOR']);

    //     $response = $this->postJson('/api/profesores', [
    //         'nombre' => 'Juan',
    //         'apellido' => 'Pérez',
    //         'user_id' => $user->id
    //     ]);

    //     $response->assertStatus(201)
    //             ->assertJsonFragment(['nombre' => 'Juan']);

    //     $this->assertDatabaseHas('profesores', ['nombre' => 'Juan']);
    // }
}
