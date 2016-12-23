<?php

use Illuminate\Database\Seeder;

use App\OrderType;

class OrderTypesTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $types = [
            'direct sale',
            'consignment',
        ];

        foreach ($types as $name) {
            $orderType = new OrderType([
                'name' => $name,
            ]);
            $orderType->saveOrFail();
        }
    }
}
