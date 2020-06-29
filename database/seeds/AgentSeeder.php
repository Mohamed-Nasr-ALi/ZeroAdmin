<?php

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class AgentSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        DB::table('agents')->insert([
            'user_id' => 2,
            'type_id' => 1,
            'business_name' => "KFC"
        ]);

        DB::table('agents')->insert([
            'user_id' => 3,
            'type_id' => 1,
            'business_name' => "LFC"
        ]);

        DB::table('agents')->insert([
            'user_id' => 4,
            'type_id' => 1,
            'business_name' => "BFC"
        ]);

        DB::table('agents')->insert([
            'user_id' => 5,
            'type_id' => 1,
            'business_name' => "CFC"
        ]);
    }
}
