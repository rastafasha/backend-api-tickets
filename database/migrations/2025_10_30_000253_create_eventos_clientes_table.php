<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateEventosClientesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('eventos_clientes', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('event_id');
            $table->unsignedBigInteger('client_id');
            $table->timestamps();

            $table->foreign('event_id')->references('id')->on('eventos')->onDelete('cascade');
            $table->foreign('client_id')->references('id')->on('clientes')->onDelete('cascade');

            $table->unique(['event_id', 'client_id']);
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('eventos_clientes');
    }
}
