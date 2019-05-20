<?php

use App\Models\Crypto;
use Faker\Generator as Faker;

$factory->define(Crypto::class, function (Faker $faker) {
    return [
        'name' => $faker->name
    ];
});
