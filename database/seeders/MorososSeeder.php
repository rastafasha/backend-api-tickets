<?php

namespace Database\Seeders;

use App\Models\Cliente;
use App\Models\Evento;
use Illuminate\Database\Seeder;
use App\Models\Moroso;
use Illuminate\Support\Facades\DB;

class MorososSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        // Clear existing morosos data
        DB::table('morosos')->truncate();

        // Get some clientes and eventos to create sample morosos
        $clientes = Cliente::take(5)->get();
        $eventos = Evento::take(5)->get();

        $currentYear = date('Y');
        $currentMonth = date('m');

        foreach ($clientes as $cliente) {
            foreach ($eventos as $evento) {
                // Only create moroso if student belongs to the parent
                if ($evento->client_id === $cliente->id) {
                    Moroso::create([
                        'client_id' => $cliente->id,
                        'evento_id' => $evento->id,
                        'month' => $currentMonth,
                        'year' => $currentYear,
                        'amount_due' => 400,
                        'amount_paid' => 0,
                        'status' => 'unpaid',
                    ]);
                }
            }
        }
    }
}
