<?php

use Illuminate\Database\Seeder;
use App\ProductType;

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
            ProductType::create([
                'name' => $t['name'],
                'monthValidity' =>$t['monthValidity'],
            ]);
        }
    }
}
