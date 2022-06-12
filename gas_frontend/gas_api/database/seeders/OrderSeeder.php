<?php

namespace Database\Seeders;

use App\Models\Order;
use Illuminate\Database\Seeder;

class OrderSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run($company_id, $user_id)
    {
        Order::insert([
            [
                'gas_quantity' => '20',
                'amount' =>  '300',
                'customer_name' =>  'Jazam',
                'unit_price' =>  '600',
                'status' => 'Paid',
                'user_id' =>  $user_id,
                'payment_mode' =>  'Prepaid',
                'order_id' =>  '0000000' . mt_rand(100, 999),
                'company_id' =>  $company_id,
                'created_at' => date('Y-m-d H:i:s'),
                'updated_at' => date('Y-m-d H:i:s'),
            ],
            [
                'gas_quantity' => '180',
                'amount' =>  '3600',
                'customer_name' =>  'Asma',
                'unit_price' =>  '18',
                'status' => 'Unpaid',
                'user_id' =>  $user_id,
                'payment_mode' =>  'Cash',
                'order_id' =>  '0000000' . mt_rand(100, 999),
                'company_id' =>  $company_id,
                'created_at' => date('Y-m-d H:i:s'),
                'updated_at' => date('Y-m-d H:i:s'),
            ],
            [
                'gas_quantity' => '555',
                'amount' =>  '3003',
                'customer_name' =>  'Bilal',
                'unit_price' =>  '1600',
                'status' => 'Paid',
                'user_id' =>  $user_id,
                'payment_mode' =>  'Prepaid',
                'order_id' =>  '0000000' . mt_rand(100, 999),
                'company_id' =>  $company_id,
                'created_at' => date('Y-m-d H:i:s'),
                'updated_at' => date('Y-m-d H:i:s'),
            ],
            [
                'gas_quantity' => '143',
                'amount' =>  '3001',
                'customer_name' =>  'Jasim',
                'unit_price' =>  '6000',
                'status' => 'Unpaid',
                'user_id' =>  $user_id,
                'payment_mode' =>  'Cash',
                'order_id' =>  '0000000' . mt_rand(100, 999),
                'company_id' =>  $company_id,
                'created_at' => date('Y-m-d H:i:s'),
                'updated_at' => date('Y-m-d H:i:s'),
            ],

            [
                'gas_quantity' => '90',
                'amount' =>  '670',
                'customer_name' =>  'Ale',
                'unit_price' =>  '9500',
                'status' => 'Pickedup',
                'user_id' =>  $user_id,
                'payment_mode' =>  'Prepaid',
                'order_id' =>  '0000000' . mt_rand(100, 999),
                'company_id' =>  $company_id,
                'created_at' => date('Y-m-d H:i:s'),
                'updated_at' => date('Y-m-d H:i:s'),
            ],
        ]);
    }
}
