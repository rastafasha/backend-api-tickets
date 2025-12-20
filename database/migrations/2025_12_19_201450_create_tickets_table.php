<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateTicketsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('tickets', function (Blueprint $table) {
             $table->id();
             $table->unsignedBigInteger('client_id')->nullable();
             $table->unsignedBigInteger('from_id')->nullable();
             $table->unsignedBigInteger('company_id')->nullable();
             $table->unsignedBigInteger('event_id')->nullable();
            $table->string('event_name');
            $table->string('referencia', 250);
            $table->double('monto', 15, 2)->nullable();
            $table->timestamp('fecha_inicio');
            $table->timestamp('fecha_fin')->nullable();
            $table->text('qr_code')->nullable();
            $table->enum('status', [
                'SHARED', 'INACTIVE', 'ACTIVE', 'EXPIRED'
                ])->default('INACTIVE');

            $table->timestamps();
            $table->softDeletes();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('tickets');
    }
}
