<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateNotificationsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('notifications', function (Blueprint $table) {
            $table->increments('id');
            $table->unsignedInteger('user_send');
            $table->foreign('user_send')->references('id')->on('users');

            $table->unsignedInteger('user_receive');
            $table->foreign('user_receive')->references('id')->on('users');

            $table->smallInteger('type')->default(0);

            $table->unsignedInteger('post_id')->nullable();
            $table->foreign('post_id')->references('id')->on('posts');
            $table->unsignedInteger('trip_id')->nullable();
            $table->foreign('trip_id')->references('id')->on('trips');

            $table->tinyInteger('seen')->default(0);

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
        Schema::dropIfExists('notifications');
    }
}
