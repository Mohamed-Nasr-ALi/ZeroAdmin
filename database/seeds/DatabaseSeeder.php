<?php

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

        if (app()->environment() === 'local'){
            // Ask for db migration refresh, default is no
            if ($this->command->confirm('Do you wish to refresh migration before seeding, it will clear all old data ?')) {

                // Call the php artisan migrate:fresh using Artisan
                $this->command->call('migrate:fresh');

                $this->command->line("Database cleared.");
            }
            $this->call([
                UserSeeder::class,
                WalletSeeder::class,
                TypeSeeder::class,
                AgentSeeder::class,
                FriendSeeder::class,
                CountrySeeder::class
            ]);
            $this->command->info("Database seeded.");
        }else{
            $this->call([
                UserSeeder::class,
                WalletSeeder::class,
                TypeSeeder::class,
                AgentSeeder::class,
                FriendSeeder::class,
                CountrySeeder::class
            ]);
        }

    }
}
