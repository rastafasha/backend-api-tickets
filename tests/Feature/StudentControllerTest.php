<?php

namespace Tests\Feature;

use Tests\TestCase;
use Illuminate\Foundation\Testing\RefreshDatabase;

class StudentControllerTest extends TestCase
{
    use RefreshDatabase;

    /** @test */
    public function it_registers_a_student_successfully()
    {
        $client = \App\Models\Cliente::factory()->create();

        $data = [
            'n_doc' => '123456789',
            'name' => 'Test Student',
            'birth_date' => '2000-01-01 00:00:00',
            'client_id' => $client->id,
            'matricula' => 1000,
        ];

        $response = $this->postJson(route('student.store'), $data);

        $response->assertStatus(200);
        $this->assertDatabaseHas('students', [
            'n_doc' => '123456789',
            'name' => 'Test Student',
        ]);
    }

    /** @test */
    public function it_fails_to_register_duplicate_student()
    {
        $client = \App\Models\Cliente::factory()->create();

        $event = \App\Models\Evento::factory()->create([
            'n_doc' => '123456789',
            'client_id' => $client->id,
        ]);

        $data = [
            'n_doc' => '123456789',
            'name' => 'Duplicate Student',
            'birth_date' => '2000-01-01 00:00:00',
            'client_id' => $client->id,
            'matricula' => 1000,
        ];

        $response = $this->postJson(route('student.store'), $data);

        $response->assertStatus(200);
        $response->assertJson([
            'message' => 403,
            'message_text' => 'el paciente ya existe',
        ]);
    }
}
