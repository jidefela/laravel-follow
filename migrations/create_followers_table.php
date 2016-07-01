<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;


class CreateFollowersTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('followers', function (Blueprint $table) {

            $table->increments('id');
            $table->unsignedInteger('follower_id')->index();
            $table->string('follower_type')->index();
            $table->unsignedInteger('followed_id')->index();
            $table->unsignedInteger('followed_type')->index();
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
        //
        Schema::drop('followers');
    }
}
