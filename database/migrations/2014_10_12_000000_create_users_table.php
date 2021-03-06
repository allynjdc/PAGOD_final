<?php

use Illuminate\Support\Facades\Schema;
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
            $table->string('name');
            $table->string('username');
            $table->string('profile_picture');
            $table->string('password');
            $table->string('course');
            $table->string('courses_taken');
            $table->string('preferences');
            $table->string('constraints');
            $table->string('schedule');
            $table->string('need_restart');
            $table->string('constraints_changed');
            $table->rememberToken();
            $table->timestamps();
        });

        /*
         * AppServiceProvider.php
         *
         *
         * use Illuminate\Support\Facades\Schema;
         *
         * public function boot() {
         *   Schema::defaultStringLength(191);
         * }
         *
        */
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('users');
    }
}
