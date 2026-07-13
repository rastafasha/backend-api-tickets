<?php

namespace Database\Factories;

use App\Models\Cliente;
use App\Models\Company;
use Illuminate\Database\Eloquent\Factories\Factory;

class ClienteFactory extends Factory
{
    protected $model = Cliente::class;

    public function definition()
    {
        return [
            'name' => $this->faker->name,
            'surname' => $this->faker->lastName,
            'pais_id' => null,
            'email' => $this->faker->unique()->safeEmail,
            'password' => bcrypt('password'), // Add default password to satisfy non-null constraint
            // Add other required fields with fake data as needed
        ];
    }
}
