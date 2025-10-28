<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateMorososTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('morosos', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('client_id');
            $table->unsignedBigInteger('event_id');
            $table->integer('month');
            $table->integer('year');
            $table->double('amount_due')->default(400);
            $table->double('amount_paid')->default(0);
            $table->enum('status', ['unpaid', 'paid'])->default('unpaid');
            $table->timestamps();

            // $table->foreign('client_id')->references('id')->on('clientes')->onDelete('cascade');
            // $table->foreign('event_id')->references('id')->on('eventos')->onDelete('cascade');

            $table->index(['client_id', 'event_id']);
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('morosos');
    }
}
