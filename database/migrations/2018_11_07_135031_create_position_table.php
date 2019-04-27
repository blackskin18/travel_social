<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreatePositionTable extends Migration
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
            //$table->unsignedInteger('post_id');
            //$table->foreign('post_id')->references('id')->on('posts');
            $table->integer('post_id')->nullable();

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
        Schema::dropIfExists('position');
    }
}
