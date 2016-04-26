<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

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
            $table->increments('id');
            $table->string('user_id')->unique();
            $table->string('lastname');
            $table->string('firstname');
            $table->string('middlename');
            $table->string('email')->unique();
            $table->string('password');
            $table->string('address');
            $table->integer('mobile');
            $table->integer('accesslevel');
            $table->integer('status');
            $table->boolean('confirmed')->default(0);
            $table->string('confirmation_code')->nullable;
            $table->rememberToken();
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
        Schema::drop('users');
    }
}
