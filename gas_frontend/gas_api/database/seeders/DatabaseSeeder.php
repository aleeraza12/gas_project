<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     *
     * @return void
     */
    public function run()
    {
        $this->call(CompanySeeder::class);
        $this->call(UserTypeSeeder::class);
        $this->call(CustomerTypeSeeder::class);
        $this->call(StateSeeder::class);
        $this->call(PaymentModeSeeder::class);
        $this->call(CustomerSeeder::class);

        $this->command->info('Company table seeded!');
        $this->command->info('User type table seeded!');
        $this->command->info('Customer type table seeded!');
        $this->command->info('State type table seeded!');
        $this->command->info('Payment mode table seeded!');
        $this->command->info('Customer table seeded!');
    }
}
