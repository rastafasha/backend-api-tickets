<?php

namespace Tests\Feature;

use Carbon\Carbon;
use Tests\TestCase;
use App\Models\Evento;
use App\Models\Cliente;
use App\Models\Payment;
use App\Models\Student;
use Illuminate\Foundation\Testing\RefreshDatabase;

class AdminPaymentControllerTest extends TestCase
{
    use RefreshDatabase;

    /** @test */
    public function it_generates_monthly_debt_for_clients_only_on_first_day_of_month()
    {
        // Set date to a day other than first of the month
        Carbon::setTestNow(Carbon::create(2025, 5, 2));

        $response = $this->postJson(route('payment.generateMonthlyDebtForclients'));

        $response->assertStatus(200);
        $response->assertJson([
            'message' => 'Today is not the first day of the month.',
        ]);
    }

    public function it_generates_monthly_debt_for_clients_on_first_day_of_month()
    {
        // Set date to first day of the month
        Carbon::setTestNow(Carbon::create(2025, 5, 1));

        // Create a student and client
        $client = Cliente::factory()->create();
        $event = Evento::factory()->create(['client_id' => $client->id, 'matricula' => 1000]);

        $response = $this->postJson(route('payment.generateMonthlyDebtForclients'));

        $response->assertStatus(200);
        $response->assertJson([
            'message' => 'Monthly debts generated successfully.',
        ]);

        $this->assertDatabaseHas('payments', [
            'client_id' => $client->id,
            'event_id' => $event->id,
            'monto' => $event->matricula,
            'status_deuda' => 'DEUDA',
            'status' => 'PENDING',
        ]);
    }

    /** @test */
    public function it_processes_payment_and_updates_debt_status()
    {
        $client = Cliente::factory()->create();
        $event = Evento::factory()->create(['client_id' => $client->id, 'matricula' => 1000]);

        // Create a debt payment
        $debtPayment = Payment::create([
            'client_id' => $client->id,
            'event_id' => $event->id,
            'monto' => 1000,
            'status_deuda' => 'DEUDA',
            'status' => 'PENDING',
            'metodo' => 'DEUDA',
            'referencia' => 'Test debt', // Added referencia to fix error
            'bank_name' => 'Test Bank', // Added bank_name to fix error
            'bank_destino' => 'Test Dest', // Added bank_destino to fix error
            'nombre' => $client->name, // Added nombre to fix error
            'email' => $client->email, // Added email to fix error
        ]);

        $data = [
            'monto' => 1000,
            'metodo' => 'Transferencia Dólares',
            'referencia' => 'Test payment',
            'bank_name' => 'Test Bank',
            'bank_destino' => 'Dest Bank',
            'nombre' => $client->name,
            'email' => $client->email,
            'status' => 'APPROVED',
        ];

        $response = $this->postJson(route('payment.payDebtForStudent', ['client_id' => $client->id, 'event_id' => $event->id]), $data);

        $response->assertStatus(200);
        $response->assertJson([
            'message' => 'Payment recorded successfully and debt updated',
        ]);

        $this->assertDatabaseHas('payments', [
            'client_id' => $client->id,
            'event_id' => $event->id,
            'status_deuda' => 'PAID',
            'status' => 'APPROVED',
        ]);
    }
}
