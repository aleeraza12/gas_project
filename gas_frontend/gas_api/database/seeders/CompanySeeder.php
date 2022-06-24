<?php

namespace Database\Seeders;

use App\Models\Company;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;

class CompanySeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        Company::create(
            [
                'owner_name' => 'Test',
                'company_email' =>  'test@gmail.com',
                'company_name' =>  'Test',
                'password' => Hash::make('Test123'),
                'company_phone_number' =>  '31241425',
                'city' =>  'TestCty',
                'state' => 'Abia',
                'permissions' =>  ['Dashboard', 'Orders', 'Users', 'Customers', 'Rates',  'Reconciliation', 'Wallet', 'Sales', 'Purchases', 'Settings', 'Promos', 'Rate List'],
                'address' =>  'Test address',
            ]
        );
    }
}
