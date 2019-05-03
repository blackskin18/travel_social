<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateTableTripUser extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('trip_users', function (Blueprint $table) {
            $table->increments('id');
            $table->unsignedInteger('user_id');
            $table->foreign('user_id')->references('id')->on('users');

            $table->unsignedInteger('trip_id');
            $table->foreign('trip_id')->references('id')->on('trips');

            $table->tinyInteger('type')->default(0)->comment('0:invitation, 1: join request');
            $table->tinyInteger('status')->default(0)->comment('0: pending, 1:Accepted, 2:Declined');
            $table->tinyInteger('seen')->default(0)->comment('0: not seen, 1: seen');

            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('trip_users');
    }
}
