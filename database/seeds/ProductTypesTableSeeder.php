<?php

use Illuminate\Database\Seeder;

class ProductTypesTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $types = [
            [
                'name' => 'InFo',
                'monthValidity' => 12,
            ],
            [
                'name' => 'Illuminate',
                'monthValidity' => 15,
            ],
        ];

        foreach ($types as $t) {
            DB::table('product')->insert([
                'name' => $t['name'],
                'monthValidity' => $t['monthValidity'],
                'created_at' => date('Y-m-d H:i:s'),
                'updated_at' => date('Y-m-d H:i:s'),
            ]);
        }
    }
}
