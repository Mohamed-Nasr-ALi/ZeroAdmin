<?php

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class UserSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $salt = $this->genrate_salt();
        $password = $this->hash_new_password("Alkoosh@123", $salt);

        DB::table('users')->insert([
            'full_name' => "Admin",
            'firebase_token' => "",
            'device_id' => "zdlksdl381293",
            'email' => 'cashzero11@gmail.com',
            'password' => $password,
            'account_number' => '10000000000000',
            'phone' => '+201015615997',
            'salt' => $salt,
            'pin' => '1234',
            'role' => 0,
        ]);

        DB::table('users')->insert([
            'full_name' => "Vendor1",
            'firebase_token' => "",
            'device_id' => "zdlksdl381293",
            'email' => 'cashzero111@gmail.com',
            'password' => $password,
            'account_number' => '10000000000001',
            'phone' => '+201015615941',
            'salt' => $salt,
            'pin' => '1234',
            'role' => 1,
        ]);

        DB::table('users')->insert([
            'full_name' => "Vendor2",
            'firebase_token' => "",
            'device_id' => "zdlksdl381293",
            'email' => 'cashzero115@gmail.com',
            'password' => $password,
            'account_number' => '10000000000002',
            'phone' => '+201015615911',
            'salt' => $salt,
            'pin' => '1234',
            'role' => 1,
        ]);

        DB::table('users')->insert([
            'full_name' => "Vendor3",
            'firebase_token' => "",
            'device_id' => "zdlksdl381293",
            'email' => 'cashzero116@gmail.com',
            'password' => $password,
            'account_number' => '10000000000003',
            'phone' => '+201015615912',
            'salt' => $salt,
            'pin' => '1234',
            'role' => 1,
        ]);

        DB::table('users')->insert([
            'full_name' => "Vendor4",
            'firebase_token' => "",
            'device_id' => "zdlksdl381293",
            'email' => 'cashzero117@gmail.com',
            'password' => $password,
            'account_number' => '10000000000004',
            'phone' => '+201015615913',
            'salt' => $salt,
            'pin' => '1234',
            'role' => 1,
        ]);

        //friends
        DB::table('users')->insert([
            'full_name' => "Friend 1",
            'firebase_token' => "",
            'device_id' => "zdlksdl381294",
            'email' => 'cashzero12111@gmail.com',
            'password' => $password,
            'account_number' => '10000000000005',
            'phone' => '+201016615949',
            'salt' => $salt,
            'pin' => '1234',
            'role' => 2,
        ]);
        
        DB::table('users')->insert([
            'full_name' => "Friend 2",
            'firebase_token' => "",
            'device_id' => "zdlksdl3812938",
            'email' => 'cashzero1311@gmail.com',
            'password' => $password,
            'account_number' => '10000000000006',
            'phone' => '+201095615999',
            'salt' => $salt,
            'pin' => '1234',
            'role' => 2,
        ]);
    }

    protected function genrate_salt($len = 32)
    {
        return substr(md5(uniqid(rand(), true)), 0, $len);
    }

    protected function hash_new_password($password, $salt)
    {
        if (empty($password) && empty($salt)) {
            return FALSE;
        }
        return sha1($password . $salt);
    }
}
