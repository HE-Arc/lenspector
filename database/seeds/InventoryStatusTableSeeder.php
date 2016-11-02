<?php

use Illuminate\Database\Seeder;

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
            DB::table('inventory_status')->insert([
                'status' => $s,
            ]);
        }
    }
}
