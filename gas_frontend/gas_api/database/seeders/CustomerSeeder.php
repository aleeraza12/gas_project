<?php

namespace Database\Seeders;

use App\Models\Customer;
use Illuminate\Database\Seeder;

class CustomerSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        Customer::create(
            [
                'name' => 'Hamad',
                'email' =>  'hamad@gmail.com',
                'phone_number' =>  '1291201203',
                'city' =>  'Lagos',
                'state' =>  'Abia',
                'customer_type' =>  'Distributor',
                'company_id' =>  1,
                'address' =>  'Abc road Lagos',
            ]
        );
    }
}
