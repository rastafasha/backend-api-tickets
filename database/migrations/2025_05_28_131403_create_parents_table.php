<?php

use App\Models\Cliente;
use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateParentsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('clientes', function (Blueprint $table) {
            $table->id();
             $table->string('name', 250);
            $table->string('surname',  250);
            $table->string('mobile',  50)->nullable();
            $table->timestamp('birth_date')->nullable();
            $table->tinyInteger('gender')->nullable();
            $table->unsignedBigInteger('pais_id')->nullable();
            $table->text('address')->nullable();
            $table->string('avatar')->nullable();
            $table->string('n_doc', 50)->unique()->nullable();
            $table->enum('status', [
                'ACTIVE', 'INACTIVE'
                ])->default('INACTIVE');
            
            $table->string('email')->unique()->comment('User email for login');
            $table->timestamp('email_verified_at')->nullable();
            $table->string('password')->comment('Hashed password');

            $table->rememberToken()->comment('For "remember me" functionality');
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
        Schema::dropIfExists('clientes');
    }
}
