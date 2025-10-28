<?php

namespace Database\Seeders;

use App\Models\Cliente;
use Illuminate\Database\Seeder;
use App\Models\Payment;
use Faker\Factory as Faker;
use Carbon\Carbon;

class PaymentsSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $faker = Faker::create();

        $clientes = Cliente::with('eventos')
        ->where('status', 'ACTIVE')
        ->get();

        foreach ($clientes as $cliente) {
            foreach ($cliente->eventos as $evento) {
                $monto = $faker->randomFloat(2, 100, 1000);
                $deuda = $monto * 0.5; // example calculation
                $monto_pendiente = $monto - $deuda;
                $status_deuda = null;
                if ($monto < 400) {
                    $status_deuda = 'DEUDA';
                }

                Payment::create([
                    'referencia' => $faker->unique()->bothify('REF-#####'),
                    'metodo' => $faker->randomElement(['Transferencia Dólares', 'Transferencia Bolívares', 'Pago Móvil']),
                    'bank_name' => $faker->randomElement(['Bank of America', 'Chase', 'Wells Fargo', 'Citibank']),
                    'bank_destino' => $faker->randomElement(['Bank of America', 'Chase', 'Wells Fargo', 'Citibank']),
                    'monto' => $monto,
                    'deuda' => $deuda,
                    'monto_pendiente' => $monto_pendiente,
                    'status_deuda' => $status_deuda,
                    'nombre' => $cliente->name . ' ' . $cliente->surname,
                    'email' => $cliente->email,
                    'avatar' => null,
                    'fecha' => Carbon::now(),
                    'status' => $faker->randomElement([Payment::APPROVED, Payment::PENDING, Payment::REJECTED]),
                    'event_id' => $evento->id,
                    'client_id' => $cliente->id,
                ]);
            }
        }
    }
}
