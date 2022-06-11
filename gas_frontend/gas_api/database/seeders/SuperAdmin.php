<?php

namespace Database\Seeders;

use App\Models\Company;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;

class SuperAdmin extends Seeder
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
                'company_email' =>  config('app.super_admin_email'),
                'company_name' =>  'Super Admin',
                'password' => Hash::make(config('app.super_admin_password')),
                'company_phone_number' =>  '901201',
                'city' =>  'Super Admin',
                'state' => 'Super Admin',
                'gas_plant_type' =>  'Super Admin',
                'permissions' =>  ['Dashboard', 'Orders', 'Users', 'Customers', 'Reconciliation', 'Wallet', 'Sales', 'Purchases', 'AdminSettings', 'Companies'],
                'address' =>  'Super Admin',
            ]
        );
    }
}