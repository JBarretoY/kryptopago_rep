<?php

use Illuminate\Database\Seeder;

class BandTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $data=[
            ['min' => 0,     'max' => 24000],
            ['min' => 24001, 'max'  => 120000],
            ['min' => 120001,'max' => -1],
        ];

        for( $i = 0;$i < count($data) - 1; $i++ ){
            DB::table('bands')->insert($data[$i]);
        }
    }
}
