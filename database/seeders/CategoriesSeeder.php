<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class CategoriesSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $categories = [
            ['name' => 'Conciertos', 'created_at' => now(), 'updated_at' => now()],
            ['name' => 'Teatro', 'created_at' => now(), 'updated_at' => now()],
            ['name' => 'Stand Up', 'created_at' => now(), 'updated_at' => now()],
            ['name' => 'Exposiciones', 'created_at' => now(), 'updated_at' => now()],
            ['name' => 'Deportivos', 'created_at' => now(), 'updated_at' => now()],
        ];

        DB::table('categories')->insert($categories);
    }
}
