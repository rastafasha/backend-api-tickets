<?php

namespace Database\Seeders;

use App\Models\Evento;
use Illuminate\Database\Seeder;
use App\Models\Company;
use App\Fakers\EventFakerProvider;
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
        $faker = Faker::create('es_ES');
        $faker->addProvider(new EventFakerProvider($faker));

        // Create 5 Companies
        for ($i = 0; $i < 5; $i++) {
            $company = Company::create([
                'name' => $faker->company(),
                'pais_id' => rand(1, 250),
                'description' => $faker->text($maxNbChars = 200),
                'avatar' => null,
            ]);

            // Create up to 5 events for each Company
            $eventsCount = rand(1, 5);
            for ($j = 0; $j < $eventsCount; $j++) {
                $event = Evento::create([
                    'name' => $faker->evento(),
                    'description' => $faker->promocion(),
                    'precio_general' => rand(1, 2500),
                    'precio_estudiantes' => rand(1, 1000),
                    'precio_especialistas' => rand(1, 1200),
                    'tickets_disponibles' => rand(0, 1200),
                    'fecha_inicio' => $faker->date(),
                    'fecha_fin' => $faker->date(),
                    'avatar' => null,
                    'pais_id' => rand(1, 250),
                    'company_id' => rand(1, 5),
                    'status' => $faker->randomElement(['PUBLISHED', 'INACTIVE',
                    'RETIRED','FINISHED']),
                ]);
            }
        }
    }
}
