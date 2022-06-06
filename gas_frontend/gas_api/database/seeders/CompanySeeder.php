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
                'state' => 'TestState',
                'gas_plant_type' =>  'Palnt1',
                'permissions' =>  ['Dashboard', 'Orders', 'Users', 'Customers', 'Reconciliation', 'Wallet', 'Sales', 'Purchases', 'Settings'],
                //'company_profile_picture'=>  $this->upload_attachment($request),
                'address' =>  'Test address',
            ]
        );
    }
}
