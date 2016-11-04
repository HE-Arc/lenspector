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
            'In stock',
            'In external stock',
            'Sold',
            'Inventory return',
        ];
        foreach ($statuses as $s) {
            InventoryStatus::create([
                'status' => $s,
            ]);
        }
    }
}
