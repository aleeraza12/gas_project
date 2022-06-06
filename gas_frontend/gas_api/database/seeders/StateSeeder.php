<?php

namespace Database\Seeders;

use App\Models\States;
use Illuminate\Database\Seeder;
use NunoMaduro\Collision\Adapters\Phpunit\State;

class StateSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        States::insert([

            [
                'company_id' => 1,
                'state_name' => 'Abia',
                'created_at' => date('Y-m-d H:i:s'),
                'updated_at' => date('Y-m-d H:i:s'),
            ],
            [
                'company_id' => 1,
                'state_name' => 'Ekiti',
                'created_at' => date('Y-m-d H:i:s'),
                'updated_at' => date('Y-m-d H:i:s'),
            ]
        ]);
    }
}
