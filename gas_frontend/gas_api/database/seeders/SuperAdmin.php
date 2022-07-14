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
                'company_phone_number' =>  '901201111',
                'city' =>  'Super Admin',
                'state' => 'Super Admin',
                'status' => 'Active',
                'is_super_admin' => true,
                'permissions' =>  ['Dashboard', 'Orders', 'Users', 'Rates', 'Customers', 'Reconciliation', 'Wallet', 'Sales', 'Purchases', 'AdminSettings', 'Companies', 'Promos', 'Rate List', 'Depos'],
                'address' =>  'Super Admin',
            ]
        );
    }
}
