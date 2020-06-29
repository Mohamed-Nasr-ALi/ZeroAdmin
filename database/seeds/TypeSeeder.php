<?php

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class TypeSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        DB::table('types')->insert([
            'type_name' => "Theater",
            'state' => 1
        ]);

        DB::table('types')->insert([
            'type_name' => "Marketing",
            'state' => 1
        ]);

        DB::table('types')->insert([
            'type_name' => "Restourant",
            'state' => 1
        ]);

        DB::table('types')->insert([
            'type_name' => "Theater",
            'state' => 1
        ]);

        DB::table('types')->insert([
            'type_name' => "Marketing",
            'state' => 1
        ]);

        DB::table('types')->insert([
            'type_name' => "Restourant",
            'state' => 1
        ]);

        DB::table('types')->insert([
            'type_name' => "customer support",
            'state' => 0
        ]);
    }
}
