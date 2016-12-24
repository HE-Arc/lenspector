<?php

use App\OrderType;
use App\InventoryStatus;
use Illuminate\Database\Seeder;

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
            [
                'name' => 'direct sale',
                'inventoryStatus' => 'sales',
            ],
            [
                'name' => 'consignment',
                'inventoryStatus' => 'consignment',
            ]
        ];

        foreach ($types as $t) {
            $inventoryStatus = inventoryStatus::where('name', $t['inventoryStatus'])
                ->first();
            $orderType = new OrderType([
                'name' => $t['name'],
                'inventory_status_id' => $inventoryStatus->id,
            ]);
            $orderType->saveOrFail();
        }
    }
}
