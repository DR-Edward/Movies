<?php

/** @var \Illuminate\Database\Eloquent\Factory $factory */

use App\Movie;
use Faker\Generator as Faker;

$factory->define(Movie::class, function (Faker $faker) {
    return [
        'name' => $this->faker->name,
        'publicationDate' => $this->faker->date(),
        'active' => $this->faker->boolean($chanceOfGettingTrue = 50),
        'imageLink' => $this->faker->image($dir = '/tmp', $width = 640, $height = 480),
    ];
});
