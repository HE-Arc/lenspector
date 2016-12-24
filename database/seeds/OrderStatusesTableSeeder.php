<?php

use App\OrderStatus;
use Illuminate\Database\Seeder;

class OrderStatusesTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $statusNames = [
            'opened',
            'shipped',
            'delivered',
            'closed',
        ];
        foreach ($statusNames as $name) {
            $orderStatus = new OrderStatus([
                'name' => $name,
            ]);
            $orderStatus->saveOrFail();
        }
    }
}