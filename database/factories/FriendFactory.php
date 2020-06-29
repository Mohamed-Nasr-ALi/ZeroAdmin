<?php

/** @var Factory $factory */

use App\Friend;
use Faker\Generator as Faker;
use Illuminate\Database\Eloquent\Factory;

$factory->define(Friend::class, static function (Faker $faker) {
    return [
        //
        'full_name'=> $faker->name,
        'phone_number'=>$faker->phoneNumber
    ];
});
