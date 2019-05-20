<?php

use Illuminate\Database\Seeder;

class CommerceTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        DB::table('commerces')->insert([
            'name' => 'commerce2',
            'rif'  => 'gfdvtt433',
            'phone' => '43454465',
            'email' => 'admin2@kryptpay.com',
            'addres' =>'thethethw',
            'city' => 'rgerg',
            'state' => 'fregre',
            'type' => null,
            'created_at' => date('Y-m-d H:m:s'),
            'updated_at' => date('Y-m-d H:m:s')
        ]);

        DB::table('commerces')->insert([
            'name' => 'commerce3',
            'rif'  => 'vfdfrete',
            'phone' => '4344353454465',
            'email' => 'admin3@kryptpay.com',
            'addres' =>'dfvdfbdfd',
            'city' => 'rgegfbfdncgrg',
            'state' => 'fgbfgb',
            'type' => null,
            'created_at' => date('Y-m-d H:m:s'),
            'updated_at' => date('Y-m-d H:m:s')
        ]);
    }
}
