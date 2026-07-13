<?php

namespace Database\Seeders;

use App\Models\Evento;
use Illuminate\Database\Seeder;
use App\Models\Cliente;
use App\Models\Company; 
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

        // 2. Traemos todas las IDs de las empresas ya creadas (asegúrate de correr CompanySeeder antes)
        // Si no tienes empresas creadas aún, puedes usar: $companyId = Company::factory()->create()->id; dentro del bucle.
        $companyIds = Company::pluck('id')->toArray();

        // Create 10 Clientes
        for ($i = 0; $i < 10; $i++) {
            $client = Cliente::create([
                'name' => $faker->firstName,
                'surname' => $faker->lastName,
                'email' => $faker->unique()->safeEmail,
                'password' => bcrypt('password'),
                'n_doc' => $faker->unique()->numerify('##########'),
                'mobile' => $faker->phoneNumber,
                'birth_date' => $faker->date(),
                'gender' => $faker->randomElement(['1', '2']),
                'address' => $faker->address,
                'avatar' => null,
                'pais_id' => rand(1, 5),
                'status' => $faker->randomElement(['ACTIVE', 'INACTIVE']),
            ]);

            // Assign GUEST role from parent-api guard
            $client->assignRole('CLIENT');

            // 3. Asociamos el cliente a una empresa aleatoria en la tabla intermedia
            if (!empty($companyIds)) {
                $randomCompanyId = $faker->randomElement($companyIds);
                
                // Opción A: Usando la relación definida en tu modelo Cliente (ej. 'companies')
                $client->companies()->attach($randomCompanyId);

                // Opción B: Si tu relación en el modelo Cliente se llama 'company'
                // $client->company()->attach($randomCompanyId);
            }
        }
    }
}
