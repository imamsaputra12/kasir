<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateProfilesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
{
    Schema::create('profiles', function (Blueprint $table) {
        $table->increments('profile_id');
        $table->integer('user_id')->unsigned();
        $table->string('bio')->nullable();
        $table->string('phone')->nullable();
        $table->string('address')->nullable();
        $table->string('image')->nullable();
        $table->timestamps();

        $table->foreign('user_id')->references('id')->on('users')->onDelete('cascade');
    });
}


    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('profiles');

    }
}
