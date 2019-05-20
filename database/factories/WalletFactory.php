<?php

use App\Models\Commerce;
use App\Models\Crypto;
use App\Models\Wallet;
use Faker\Generator as Faker;

$factory->define(Wallet::class, function (Faker $faker) {
    return [
        'name' => $faker->name,
        'public_key' => $faker->text(64),

        'commerce_id' => function () {
            factory(Commerce::class)->create()->id;
        },
        'crypto_id' => function () {
            factory(Crypto::class)->create()->id;
        }
    ];
});
