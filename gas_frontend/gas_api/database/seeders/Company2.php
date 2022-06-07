<?php

namespace Database\Seeders;

use App\Models\Company;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;

class Company2 extends Seeder
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
                'owner_name' => 'Super Admin',
                'company_email' =>  'superadmin@gmail.com',
                'company_name' =>  'Super Admin',
                'password' => Hash::make('Superadmin123.'),
                'company_phone_number' =>  '901201',
                'city' =>  'Super Admin',
                'state' => 'Super Admin',
                'gas_plant_type' =>  'Super Admin',
                'permissions' =>  ['Dashboard', 'Orders', 'Users', 'Customers', 'Reconciliation', 'Wallet', 'Sales', 'Purchases', 'Settings', 'Companies'],
                'address' =>  'Super Admin',
            ]
        );
    }
}
