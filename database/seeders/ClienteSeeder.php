<?php

namespace Database\Seeders;

use App\Models\Evento;
use Illuminate\Database\Seeder;
use App\Models\Cliente;
use App\Models\Student;
use Faker\Factory as Faker;

class ClienteSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $faker = Faker::create();

        // Create 10 Clientes
        for ($i = 0; $i < 10; $i++) {
            $client = Cliente::create([
                'name' => $faker->firstName,
                'surname' => $faker->lastName,
                'email' => $faker->unique()->safeEmail,
                'password' => bcrypt('password'), // default password
                'n_doc' => $faker->unique()->numerify('##########'),
                'mobile' => $faker->phoneNumber,
                'birth_date' => $faker->date(),
                'gender' => $faker->randomElement(['1', '2']),
                'address' => $faker->address,
                'avatar' => null,

                'status' => $faker->randomElement(['ACTIVE', 'INACTIVE']),
            ]);

            // Assign GUEST role from parent-api guard
            $client->assignRole('CLIENT');

            // Create up to 5 events for each Cliente
            $eventsCount = rand(1, 5);
            for ($j = 0; $j < $eventsCount; $j++) {
                $event = Evento::create([
                    'name' => $faker->firstName,
                    'precio_general' => 1000,
                    'precio_estudiantes' => 1000,
                    'precio_especialistas' => 1000,
                    'fecha_inicio' => $faker->date(),
                    'fecha_fin' => $faker->date(),
                    'avatar' => null,
                    // 'user_id' => 4,
                    'status' => $faker->randomElement(['ACTIVE', 'INACTIVE',
                    'RETIRED','FINISHED']),
                ]);
                $event->clients()->attach($client);
            }
        }
    }
}
