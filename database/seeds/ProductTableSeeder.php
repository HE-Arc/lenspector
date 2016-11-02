<?php

use Illuminate\Database\Seeder;

class ProductTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        for ($i = 1; $i <= 100; $i++) {
            DB::table('lense')->insert([
                'sn' => 'F'.str_pad($i, 8, '0', STR_PAD_LEFT),
                'dateExpiration' => '2018-06-21',
                'exclude' => random_int(0, 1),
                'productId' => 1,
                'sphCorrected' => random_int(10, 60) * 0.5,
                'status' => random_int(1, 4),
                'created_at' => date('Y-m-d H:i:s'),
                'updated_at' => date('Y-m-d H:i:s'),
            ]);
        }
    }
}
