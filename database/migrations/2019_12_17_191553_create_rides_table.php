<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateRidesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('rides', function (Blueprint $table) {
            $table->engine = 'InnoDB';

            $table->increments('id');
            $table->unsignedInteger('instructor');
            $table->unsignedInteger('student')->nullable();
            $table->date('date');
            $table->time('time_start');
            $table->time('time_stop');
            $table->float('amount_hours');
            $table->timestamps();
            $table->unsignedInteger('status_id');

           $table->foreign('status_id')
           ->references('id')->on('statuses')
           ->onDelete('cascade');
   
           $table->foreign('instructor')
           ->references('id')->on('users')
           ->onDelete('cascade');
   
           $table->foreign('student')
           ->references('id')->on('users')
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
        Schema::dropIfExists('rides');
    }
}
