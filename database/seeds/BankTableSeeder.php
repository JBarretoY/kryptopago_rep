<?php

use Illuminate\Database\Seeder;

class BankTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $banks = ['MERCANTIL','BANESCO','PROVINCIAL','BOD','BNC'];

        for( $i=0; $i < count($banks) - 1; $i++ ){
            DB::table('banks')->insert(
                ['name'       => $banks[$i],
                    'created_at' => \Carbon\Carbon::now()->toDateTimeString(),
                    'updated_at' => \Carbon\Carbon::now()->toDateTimeString()
                ]);
        }
    }
}
