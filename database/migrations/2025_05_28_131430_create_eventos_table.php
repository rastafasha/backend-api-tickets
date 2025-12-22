<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateEventosTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('eventos', function (Blueprint $table) {
            $table->id();
            $table->string('name');
            $table->text('description')->nullable();
            $table->unsignedBigInteger('company_id')->nullable();
            $table->timestamp('fecha_inicio');
            $table->timestamp('fecha_fin')->nullable();
            $table->string('tickets_disponibles')->nullable();
            $table->double('precio_general', 15, 2);
            $table->double('precio_estudiantes', 15, 2)->nullable();
            $table->double('precio_especialistas', 15, 2)->nullable();
            $table->string('avatar')->nullable();
            $table->unsignedBigInteger('pais_id')->nullable();
            $table->enum('status', [
                'PUBLISHED', 'INACTIVE','RETIRED','FINISHED'
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
        Schema::dropIfExists('eventos');
    }
}
