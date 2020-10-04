<?php

/** @var \Illuminate\Database\Eloquent\Factory $factory */

use App\Turn;
use Faker\Generator as Faker;

$factory->define(Turn::class, function (Faker $faker) {
    return [
        'time' => $faker->time(),
        'active' => $faker->boolean($chanceOfGettingTrue = 50),
    ];
});
