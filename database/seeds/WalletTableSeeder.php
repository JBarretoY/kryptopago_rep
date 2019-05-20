<?php

use Illuminate\Database\Seeder;

class WalletTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        DB::table('wallets')->insert([
            'name' => "rtrdgdregr",
            'public_key' => "thtfyrthfthth",
            'created_at' => date('Y-m-d H:m:s'),
            'updated_at' => date('Y-m-d H:m:s')
        ]);

        DB::table('wallets')->insert([
            'name' => "rrgrdfgg45",
            'public_key' => "bgfhfhdgthtdh",
            'created_at' => date('Y-m-d H:m:s'),
            'updated_at' => date('Y-m-d H:m:s')
        ]);

        DB::table('wallets')->insert([
            'name' => "454fdfg",
            'public_key' => "hgmhjkhukuk",
            'created_at' => date('Y-m-d H:m:s'),
            'updated_at' => date('Y-m-d H:m:s')
        ]);
    }
}
