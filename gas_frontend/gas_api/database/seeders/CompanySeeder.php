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
                'gas_plant_type' =>  'plant 3',
                'permissions' =>  ['Dashboard', 'Orders', 'Users', 'Customers', 'Reconciliation', 'Wallet', 'Sales', 'Purchases', 'Settings'],
                'address' =>  'Test address',
            ]
        );
    }
}
