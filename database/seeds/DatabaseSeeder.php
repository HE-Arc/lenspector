<?php

use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $this->call(UsersTableSeeder::class);
        $this->call(InventoryStatusTableSeeder::class);
        $this->call(ProductTypesTableSeeder::class);
        $this->call(ProductTableSeeder::class);
        $this->call(CountriesSeeder::class);
        $this->call(CustomersTableSeeder::class);
    }
}
