<?php

use Illuminate\Database\Seeder;

class UserTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        DB::table('users')->insert([
            'name' => 'Admin',
            'lastname' => '1',
            'email' => 'admin1@kryptpay.com',
            'password' => bcrypt(12345678),
            'type'  => 1,
            'phone' => 147258,
            'last_sesion' => '',
            'checked'     => 1,
            'created_at' => date('Y-m-d H:m:s'),
            'updated_at' => date('Y-m-d H:m:s')
        ]);

        DB::table('users')->insert([
            'name' => 'usertest2',
            'lastname' => 'test2',
            'email' => 'admin2@kryptpay.com',
            'password' => bcrypt(87654321),
            'type'  => 2,
            'phone' => 963852,
            'commerce_id' => 1,
            'last_sesion' => '',
            'checked'     => 1,
            'created_at' => date('Y-m-d H:m:s'),
            'updated_at' => date('Y-m-d H:m:s')
        ]);

        DB::table('users')->insert([
            'name' => 'usertest3',
            'lastname' => 'test3',
            'email' => 'usertest3@kryptpay.com',
            'password' => bcrypt(12345678),
            'type'  => 3,
            'commerce_id' => 2,
            'phone' => 56546,
            'last_sesion' => 'php',
            'checked'     => 1,
            'created_at' => date('Y-m-d H:m:s'),
            'updated_at' => date('Y-m-d H:m:s')
        ]);

    }
}
