<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreatePaymentsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('payments', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->string('referencia', 250);
            $table->string('metodo', 250);
            $table->string('bank_name', 250);
            $table->string('bank_destino', 250);
            $table->double('monto', 15, 2);
            $table->string('nombre', 250);
            $table->string('email', 250);
            $table->string('avatar', 250)->nullable();
            $table->timestamp('fecha');
            $table->enum('status', [
                'APPROVED',
                'PENDING',
                'REJECTED'
            ])->default('PENDING');

            $table->double('deuda')->default(0);
            $table->double('monto_pendiente')->default(0);
            $table->string('status_deuda')->nullable();

            // Provider IDs
            $table->unsignedBigInteger('event_id')->nullable();
            $table->unsignedBigInteger('client_id')->nullable();

            $table->timestamps();
            $table->softDeletes();

            // Foreign keys for provider relationships
            $table->foreign('event_id')->references('id')->on('eventos')->nullOnDelete();
            $table->foreign('client_id')->references('id')->on('clientes')->nullOnDelete();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('payments');
        
    }
}
