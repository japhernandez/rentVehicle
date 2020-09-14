<?php

/** @var \Illuminate\Database\Eloquent\Factory $factory */

use App\Models\Vehicle;
use Faker\Generator as Faker;

$factory->define(Vehicle::class, function (Faker $faker) {
    return [
        'id' => $faker->randomNumber(1),
        'license_plate' => $faker->name,
        'color' => $faker->colorName,
        'year' => $faker->date('Y-m-d'),
        'model' => $faker->name,
        'rental_value' => $faker->randomNumber(6),
        'availability' => 1
    ];
});
