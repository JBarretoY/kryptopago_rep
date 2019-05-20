<?php

use Illuminate\Database\Seeder;

class CryptoTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $data = [
            [
                'name'=>'BTC',
                'created_at'=>date('Y-m-d H:m:s'),
                'updated_at'=>date('Y-m-d H:m:s')
            ],
            [
                'name'=>'DASH',
                'created_at'=>date('Y-m-d H:m:s'),
                'updated_at'=>date('Y-m-d H:m:s')
            ],
        ];
        DB::table('cryptos')->insert($data);
    }
}
