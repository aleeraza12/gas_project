<?php

namespace Database\Seeders;

use App\Models\User;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;

class UserSeeder extends Seeder
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
                'name' => 'Test',
                'created_by' => 'Test',
                'password' =>  Hash::make('Test123'),
                'designation' =>  'Finance',
                'permissions' =>   ['Sales', 'Purchases'],
                'user_type' =>  'User',
                'status' =>  'Active',
                'company_id' =>  1,
            ]
        );
    }
}
