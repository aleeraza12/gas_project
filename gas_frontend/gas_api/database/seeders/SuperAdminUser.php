<?php

namespace Database\Seeders;

use App\Models\User;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;

class SuperAdminUser extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        User::create(
            [
                'name' => 'Super Admin',
                'created_by' => 'Super Admin',
                'password' =>  Hash::make(config('app.super_admin_password')),
                'designation' =>  'Super Admin',
                'permissions' =>    ['Dashboard', 'Orders', 'Users', 'Customers', 'Reconciliation', 'Wallet', 'Sales', 'Purchases', 'AdminSettings', 'Companies'],
                'user_type' =>  'Super Admin',
                'status' =>  'Active',
                'company_id' =>  2,
            ]
        );
    }
}
