<?php

namespace Tests\Feature;

use App\Models\Cliente;
use App\Models\Evento;
use Tests\TestCase;
use App\Models\Student;
use App\Models\Payment;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Carbon\Carbon;

class InitialDebtGenerationTest extends TestCase
{
    use RefreshDatabase;

    /** @test */
    public function it_generates_initial_debt_for_event_on_registration()
    {
        Carbon::setTestNow(Carbon::create(2025, 6, 15));

        $client = Cliente::factory()->create();
        $event = Evento::factory()->create(['client_id' => $client->id, 'matricula' => 1500]);

        // Call the function directly to simulate registration
        app(\App\Http\Controllers\Admin\AdminPaymentController::class)
            ->generateInitialDebtForStudent($event->id);

        $this->assertDatabaseHas('payments', [
            'client_id' => $client->id,
            'event_id' => $event->id,
            'monto' => 1500,
            'status_deuda' => 'DEUDA',
            'status' => 'PENDING',
            'referencia' => 'Initial debt for June 2025',
        ]);
    }

    /** @test */
    public function it_does_not_duplicate_initial_debt_if_already_exists_for_month()
    {
        Carbon::setTestNow(Carbon::create(2025, 6, 15));

        $client = Cliente::factory()->create();
        $event = Evento::factory()->create(['client_id' => $client->id, 'matricula' => 1500]);

        // Create an existing debt for this month
        Payment::create([
            'client_id' => $client->id,
            'event_id' => $event->id,
            'monto' => 1500,
            'status_deuda' => 'DEUDA',
            'status' => 'PENDING',
            'referencia' => 'Initial debt for June 2025',
            'metodo' => 'DEUDA',
            'bank_name' => '',
            'bank_destino' => '',
            'nombre' => $client->name,
            'email' => $client->email,
            'avatar' => null,
        ]);

        // Call the function again
        app(\App\Http\Controllers\Admin\AdminPaymentController::class)
            ->generateInitialDebtForStudent($event->id);

        // Assert only one record exists
        $payments = Payment::where('client_id', $client->id)
            ->where('event_id', $event->id)
            ->whereDate('created_at', '>=', Carbon::now()->startOfMonth())
            ->whereDate('created_at', '<=', Carbon::now()->endOfMonth())
            ->get();

        $this->assertCount(1, $payments);
    }
}
