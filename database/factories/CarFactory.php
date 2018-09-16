<?php

use App\User;
use Faker\Generator as Faker;

$factory->define(App\Car::class, function (Faker $faker) {
    $users = User::get(['id']);
    return [
        'make' => $faker->firstName,
        'model' => $faker->firstName,
        'user_id' => $users->random()->id,
    ];
});
