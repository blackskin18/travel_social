<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateMyPositionTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('positions', function (Blueprint $table) {
            $table->increments('id');
            $table->unsignedInteger('post_id');
            //$table->integer('post_id');
            $table->foreign('post_id')->references('id')->on('posts')->nullable();

            $table->unsignedInteger('trip_id');
            //$table->integer('trip_id');
            $table->foreign('trip_id')->references('id')->on('trips')->nullable();

            $table->float('lat', 10, 6);
            $table->float('lng', 10, 6);

            $table->longText('description')->nullable();
            $table->dateTime('time_arrive')->nullable();
            $table->dateTime('time_leave')->nullable();

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
        Schema::dropIfExists('positions');
    }
}
