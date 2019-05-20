<?php

use App\Models\Commerce;
use App\Models\User;
use App\Models\Wallet;
use App\Models\Transaction;
use Faker\Generator as Faker;

$factory->define(Transaction::class, function (Faker $faker) {
    return [
        'date'          => now()->toDateString(),
        'amount_bs'     => (float) random_int(100, 5000),
        'amount_crypto' => (float) random_int(100, 5000),
        'reference'     => random_int(0, 999),
        'btc_value'     => (float) random_int(100, 5000),
        'txid'          => $faker->text,
        'validate'      => false,

        'user_id' => function () {
            return factory(User::class)->create()->id;
        },

        'commerce_id' => function () {
            return factory(Commerce::class)->create()->id;
        },

        'wallet_id' => function () {
            return factory(Wallet::class)->create()->id;
        }
    ];
});
