<?php

use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $this->call(CommerceTableSeeder::class);
        $this->call(UserTableSeeder::class);
        $this->call(BandTableSeeder::class);
        $this->call(BankTableSeeder::class);
        $this->call(WalletTableSeeder::class);
        $this->call(CryptoTableSeeder::class);
        //$this->call(TransactionTableSeeder::class);
    }
}
