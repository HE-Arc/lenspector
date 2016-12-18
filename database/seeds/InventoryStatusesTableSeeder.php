<?php

use App\InventoryStatus;
use Illuminate\Database\Seeder;

class InventoryStatusesTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $statuses = [
            'on hands',
            'consignment',
            'sales',
            // 'return',
        ];
        foreach ($statuses as $s) {
            $status = new InventoryStatus(['name' => $s]);
            $status->saveOrFail();
        }
    }
}
