<?php

use App\Models\Role;
use App\Models\User;
use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateUsersTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('users', function (Blueprint $table) {
            $table->id();
            $table->string('name', 250);
            $table->string('surname',  250);
            $table->string('n_doc', 50)->unique()->nullable();
            $table->timestamp('birth_date')->nullable();
            $table->tinyInteger('gender')->nullable();
            $table->tinyInteger('status')->default(1);
            $table->string('mobile',  50)->nullable();
            $table->string('telefono')->nullable();
            $table->text('address')->nullable();
            $table->string('avatar')->nullable();
            $table->string('empresa')->nullable();
            
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
        Schema::dropIfExists('users');
    }
}
