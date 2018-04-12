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
        'username' => str_random(9),
        'profile_picture' => 'images/default-profile-image.png',
        'password' => $password ?: $password = bcrypt('secret'),
        'course' => 'bs cmsc',
        'courses_taken' => "\"csv\\\\4thYrKomsai3.csv\"",
        'remember_token' => str_random(10),
    ];
});
