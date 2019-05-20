<?php

use App\Models\Commerce;
use Faker\Generator as Faker;

$factory->define(Commerce::class, function (Faker $faker) {
    return [
        'name' => $faker->name,
        'rif' => 'RIF-123123',
        'phone' => '123123',
        'email' => $faker->safeEmail,
        'addres' => $faker->address,
        'city' => $faker->city,
        'state' => $faker->city,
        'type' => 'a_type'
    ];
});
