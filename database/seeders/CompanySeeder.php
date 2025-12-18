<?php

namespace Database\Seeders;

use App\Models\Evento;
use Illuminate\Database\Seeder;
use App\Models\Company;
use Faker\Factory as Faker;

class CompanySeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $faker = Faker::create();

        // Create 5 Companies
        for ($i = 0; $i < 5; $i++) {
            $company = Company::create([
                'name' => $faker->name,

                'description' => $faker->text($maxNbChars = 200),
                'avatar' => null,
            ]);

            // Create up to 5 events for each Company
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
                    'status' => $faker->randomElement(['PUBLISHED', 'INACTIVE',
                    'RETIRED','FINISHED']),
                ]);
                $event->companies()->attach($company);
            }
        }
    }
}
