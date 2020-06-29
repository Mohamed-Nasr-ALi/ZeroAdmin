<?php

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class CashBackSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        //
        DB::table('cashbacks')->insert([
            'agent_id' => 1,
            'client_cashback' => 12,
            'zerocach_cashback' => 4,
        ]);

        DB::table('cashbacks')->insert([
            'agent_id' => 2,
            'client_cashback' => 11,
            'zerocach_cashback' => 3,
        ]);

        DB::table('cashbacks')->insert([
            'agent_id' => 3,
            'client_cashback' => 9,
            'zerocach_cashback' => 8,
        ]);

        DB::table('cashbacks')->insert([
            'agent_id' => 4,
            'client_cashback' => 7,
            'zerocach_cashback' => 5,
        ]);
    }
}
