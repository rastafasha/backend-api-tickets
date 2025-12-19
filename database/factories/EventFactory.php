<?php

namespace Database\Factories;

use App\Models\Evento;
use App\Models\User;
use App\Models\Company;
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
            'company_id' => Company::factory(),
            'precio_general' => $this->faker->numberBetween(500, 2000),
            'precio_estudiantes' => $this->faker->numberBetween(500, 2000),
            'precio_especialistas' => $this->faker->numberBetween(500, 2000),
            'avatar' => null,
        ];
    }

    public function configure()
    {
        return $this->afterCreating(function (Evento $evento) {
            $evento->users()->attach(
                User::factory()->count(5)->create()
            );
        });
    }
}
