<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateTableFriends extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('friends', function (Blueprint $table) {
            $table->unsignedInteger('user_one_id');
            $table->foreign('user_one_id')->references('id')->on('users');
            $table->unsignedInteger('user_two_id');
            $table->foreign('user_two_id')->references('id')->on('users');
            $table->increments('id');
            $table->smallInteger('type')->default(0)->comment('0: pending, 1:Accepted, 2:Declined, 3:Blocked');
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
        Schema::dropIfExists('friends');
    }
}
