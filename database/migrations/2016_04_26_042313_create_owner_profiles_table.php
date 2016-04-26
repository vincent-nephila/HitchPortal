<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateOwnerProfilesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('owner_profiles', function (Blueprint $table) {
            $table->increments('id');
            $table->integer('idno');
            $table->string('picture');
            $table->string('validId1');
            $table->string('validId2');
            $table->timestamps();
            $table->foreign('idno')->references('id')->on('users');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::drop('owner_profiles');
    }
}
