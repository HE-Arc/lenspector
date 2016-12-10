<?php

use Illuminate\Database\Seeder;
use App\Customer;

class CustomersTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $faker = Faker\Factory::create();
        $faker->addProvider(new Faker\Provider\fr_BE\Payment($faker));
        $departments = [
            'surgery',
            'urology',
            'ophtalmic surgery',
            'psychiatry',
        ];
        $countriesIds = DB::table('countries')->select('id')->get();
        for ($i = 0; $i < 50; $i++) {
            $customer = new Customer([
                'first_name' => $faker->firstName(),
                'last_name' => $faker->lastName(),
                'company_name' => $faker->company(),
                'department' => $departments[array_rand($departments)],
                'street_name' => $faker->streetName(),
                'building_number' => $faker->buildingNumber(),
                'post_code' => $faker->postCode(),
                'city' => $faker->city,
                'country_id' => $countriesIds->random()->id,
                'phone_number' => $faker->phoneNumber(),
                'fax_number' => $faker->phoneNumber(),
                'email' => $faker->email(),
                'vat' => $faker->vat,
            ]);
            $customer->saveOrFail();
        }
    }
}
