<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     *
     * @return void
     */
    public function run()
    {
        $this->call(UserSeeder::class);
        $this->call(PermissionsSeeder::class);
        $this->call(CompanySeeder::class);
        $this->call(TiposDePagoSeeder::class);
        $this->call(PaymentsSeeder::class);
        $this->call(PaisSeeder::class);
        $this->call(ClienteSeeder::class);
        $this->call(CategoriesSeeder::class);
    }
}
