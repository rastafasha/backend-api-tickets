<?php

namespace Database\Factories;

use App\Models\Evento;
use App\Models\Cliente;
use Illuminate\Database\Eloquent\Factories\Factory;

class EventFactory extends Factory
{
    protected $model = Evento::class;

    public function definition()
    {
        return [
            'name' => $this->faker->name,
            'description' => $this->faker->description,
            'fecha_inicio' => $this->faker->dateTimeBetween('-30 months', '6 months'),
            'fecha_fin' => $this->faker->dateTimeBetween('-30 months', '6 months'),
            'client_id' => Cliente::factory(),
            'precio_general' => $this->faker->numberBetween(500, 2000),
            'precio_estudiantes' => $this->faker->numberBetween(500, 2000),
            'precio_especialistas' => $this->faker->numberBetween(500, 2000),
            'avatar' => null,
        ];
    }
}
