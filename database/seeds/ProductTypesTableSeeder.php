<?php

use App\ProductType;
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
            $productType = new ProductType([
                'name' => $t['name'],
                'monthValidity' => $t['monthValidity'],
            ]);
            $productType->save();
        }
    }
}
