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
            $table->string('student_number')->unique();
            $table->string('password');
            $table->string('course');
            $table->string('courses_taken');
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
