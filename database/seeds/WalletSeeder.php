<?php

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class WalletSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        DB::table('wallets')->insert([
            'user_id' => "1",
            'current_balance' => 1000,
        ]);

        DB::table('wallets')->insert([
            'user_id' => "2",
            'current_balance' => 1000,
        ]);

        DB::table('wallets')->insert([
            'user_id' => "3",
            'current_balance' => 1000,
        ]);

        DB::table('wallets')->insert([
            'user_id' => "4",
            'current_balance' => 1000,
        ]);
    }
}
