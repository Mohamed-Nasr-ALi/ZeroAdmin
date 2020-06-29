<?php

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class FriendSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {

//        if (app()->environment() === 'local') {
//            //all users
//            $users = App\User::all()->take(-2);
//
//
//            // Create a range of films for each users
//            $users->each(static function ($user) use ($users) {
//                factory(App\Friend::class, 1)
//                    ->create(['user_id' => $user->id]);
//            });
//
//
//            $this->command->info('Friends Created!');
//        } else {
            DB::table('friends')->insert([
                'user_id' => "3",
                'full_name' => 'Friend 2',
                'phone_number' => '+201095615999'
            ]);

            DB::table('friends')->insert([
                'user_id' => "4",
                'full_name' => 'Friend 1',
                'phone_number' => '+201016615949'
            ]);
      //  }
    }
}
