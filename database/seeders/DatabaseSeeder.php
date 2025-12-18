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
        // \App\Models\User::factory(10)->create();
        $this->call(UserSeeder::class);
        $this->call(PermissionsSeeder::class);
        $this->call(TiposDePagoSeeder::class);
        $this->call(PaymentsSeeder::class);
        $this->call(ClienteSeeder::class);
        $this->call(CategoriesSeeder::class);
        $this->call(BlogsSeeder::class);
        $this->call(CompanySeeder::class);
        // $this->call(CalendarioTareaSeeder::class);
    }
}
