<?php

namespace Database\Factories;

use App\Models\Evento;
use App\Models\User;
use App\Models\Company;
use App\Fakers\EventFakerProvider;
use Illuminate\Database\Eloquent\Factories\Factory;

class EventFactory extends Factory
{
    protected $model = Evento::class;

    public function definition()
    {
        // Add our custom provider to the existing faker instance
        $this->faker->addProvider(new EventFakerProvider($this->faker));

        return [
            'name' => $this->faker->evento(),
            'description' => $this->faker->text($maxNbChars = 200),
            'fecha_inicio' => $this->faker->dateTimeBetween('-30 months', '6 months'),
            'fecha_fin' => $this->faker->dateTimeBetween('-30 months', '6 months'),
            'company_id' => Company::factory(),
            'tickets_disponibles' => $this->faker->numberBetween(10, 500),
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
