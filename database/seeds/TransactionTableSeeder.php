<?php

use Illuminate\Database\Seeder;
use Faker\Factory as Faker;

class TransactionTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $faker = Faker::create();

        for( $i = 0; $i < 51;$i++ ){
            DB::table('transactions')->insert(array(
                'date'          => date('Y-m-d'),
                'amount_bs'     => $faker->randomFloat(),
                'amount_crypto' => $faker->randomFloat(),
                'reference'     => $faker->randomNumber(),
                'btc_value'     => $faker->randomFloat(),
                'txid'          => substr(bin2hex(openssl_random_pseudo_bytes('5548')),0,9),
                'validate'      => $faker->randomElement([0,1]),
                'user_id'       => $faker->randomElement([2,3]),
                'wallet_id'     => $faker->randomElement([1,2]),
                'commerce_id'   => $faker->randomElement([1,2]),
                'created_at'    => date('Y-m-d H:m:s'),
                'updated_at'    => date('Y-m-d H:m:s')
            ));
        }
    }
}
