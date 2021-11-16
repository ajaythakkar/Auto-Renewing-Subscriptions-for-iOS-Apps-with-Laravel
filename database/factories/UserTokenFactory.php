<?php

/** @var \Illuminate\Database\Eloquent\Factory $factory */

use App\Models\UserToken;
use Faker\Generator as Faker;

$factory->define(UserToken::class, function (Faker $faker) {

    return [
        'user_id' => $faker->randomDigitNotNull,
        'device_token' => $faker->word,
        'created_at' => $faker->date('Y-m-d H:i:s'),
        'updated_at' => $faker->date('Y-m-d H:i:s')
    ];
});
