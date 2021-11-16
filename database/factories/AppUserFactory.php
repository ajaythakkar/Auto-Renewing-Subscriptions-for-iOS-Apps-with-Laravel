<?php

/** @var \Illuminate\Database\Eloquent\Factory $factory */

use App\Models\AppUser;
use Faker\Generator as Faker;

$factory->define(AppUser::class, function (Faker $faker) {

    return [
        'name' => $faker->word,
        'status' => $faker->randomDigitNotNull,
        'created_at' => $faker->date('Y-m-d H:i:s'),
        'updated_at' => $faker->date('Y-m-d H:i:s')
    ];
});
