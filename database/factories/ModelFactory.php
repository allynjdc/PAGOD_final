<?php

/*
|--------------------------------------------------------------------------
| Model Factories
|--------------------------------------------------------------------------
|
| Here you may define all of your model factories. Model factories give
| you a convenient way to create models for testing and seeding your
| database. Just tell the factory how a default model should look.
|
*/

/** @var \Illuminate\Database\Eloquent\Factory $factory */
$factory->define(App\User::class, function (Faker\Generator $faker) {
    static $password;

    return [
        'name' => $faker->name,
        'username' => $faker->userName,
        'profile_picture' => 'images/default-profile-image.png',
        'password' => $password ?: $password = bcrypt('secret'),
        'course' => 'bs cmsc',
        'courses_taken' => "\"csv\\\\4thYrKomsai3.csv\"",
        'preferences' => "\"preferences\\\\1.csv\"",
        'constraints' => "\"constraints\\\\1.csv\"",
        'schedule' => "\"schedule\\\\1.csv\"",
        'need_restart' => '0',
        'remember_token' => str_random(10),
    ];
});
