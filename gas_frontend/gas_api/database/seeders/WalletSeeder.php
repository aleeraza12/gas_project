<?php

namespace Database\Seeders;

use App\Models\Wallet;
use Illuminate\Database\Seeder;

class WalletSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {

        Wallet::insert([
            [
                'transaction_id' => '0000000' . mt_rand(100, 999),
                'account_name' => 'Asif',
                'account_number' => '000' . mt_rand(100000, 999999),
                'status' => 'Successfull',
                'amount' => 91600,
                'authorized_by' => 'Chima Obi'
            ],
            [
                'transaction_id' => '0000000' . mt_rand(100, 999),
                'account_name' => 'Ola Adeymani',
                'account_number' => '000' . mt_rand(100000, 999999),
                'status' => 'UnSuccessfull',
                'amount' => 31200,
                'authorized_by' => 'Chima Obi'
            ],
            [
                'transaction_id' => '0000000' . mt_rand(100, 999),
                'account_name' => 'Chintosh',
                'account_number' => '000' . mt_rand(100000, 999999),
                'status' => 'Successfull',
                'amount' => 56100,
                'authorized_by' => 'Chima Obi'
            ],
            [
                'transaction_id' => '0000000' . mt_rand(100, 999),
                'account_name' => 'Gabryal',
                'account_number' => '000' . mt_rand(100000, 999999),
                'status' => 'UnSuccessfull',
                'amount' => 90100,
                'authorized_by' => 'Chima Obi'
            ],
            [
                'transaction_id' => '0000000' . mt_rand(100, 999),
                'account_name' => 'Sabir',
                'account_number' => '000' . mt_rand(100000, 999999),
                'status' => 'Successfull',
                'amount' => 79210,
                'authorized_by' => 'Chima Obi'
            ],
            [
                'transaction_id' => '0000000' . mt_rand(100, 999),
                'account_name' => 'Sadam',
                'account_number' => '000' . mt_rand(100000, 999999),
                'status' => 'UnSuccessfull',
                'amount' => 9765,
                'authorized_by' => 'Chima Obi'
            ],
        ]);
    }
}
