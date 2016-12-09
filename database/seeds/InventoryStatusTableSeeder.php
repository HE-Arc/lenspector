<?php

use Illuminate\Database\Seeder;
use App\InventoryStatus;

class InventoryStatusTableSeeder extends Seeder
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
