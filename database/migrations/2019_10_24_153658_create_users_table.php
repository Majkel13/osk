<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

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

            //$table->engine = 'InnoDB';

            $table->increments('id');
            $table->string('name',45);
            $table->string('surname',45);
            $table->string('email',45)->unique();
            $table->string('phone',45)->nullable();
            $table->boolean('active')->nullable();
            $table->integer('amount')->nullable();
            $table->integer('amount2')->nullable();
            $table->string('password',190);
            $table->rememberToken();
            $table->timestamps();
            $table->integer('role_id');

           $table->foreign('role_id')
        ->references('id')->on('roles')
        ->onDelete('cascade');
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
