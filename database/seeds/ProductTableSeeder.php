<?php

use Illuminate\Database\Seeder;
use App\InventoryStatus;
use App\ProductType;

class ProductTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $statuses = InventoryStatus::select('id')->get();
        $productTypes = ProductType::select('id')->get();
        for ($i = 1; $i <= 100; $i++) {
            DB::table('lense')->insert([
                'sn' => 'F'.str_pad($i, 8, '0', STR_PAD_LEFT),
                'dateExpiration' => '2018-06-21',
                'exclude' => random_int(0, 1),
                'productId' => $productTypes->random()->id,
                'sphCorrected' => random_int(10, 60) * 0.5,
                'status' => $statuses->random()->id,
                'created_at' => date('Y-m-d H:i:s'),
                'updated_at' => date('Y-m-d H:i:s'),
            ]);
        }
    }
}
