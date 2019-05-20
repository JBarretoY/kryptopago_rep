<?php

use App\Models\Bank;
use Faker\Generator as Faker;

$factory->define(Bank::class, function (Faker $faker) {
    return [
        'name' => $faker->name
    ];
});
