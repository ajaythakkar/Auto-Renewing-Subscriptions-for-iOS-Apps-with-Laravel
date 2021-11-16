<?php

/** @var \Illuminate\Database\Eloquent\Factory $factory */

use App\Models\UserSubscription;
use Faker\Generator as Faker;

$factory->define(UserSubscription::class, function (Faker $faker) {

    return [
        'user_id' => $faker->randomDigitNotNull,
        'product_id' => $faker->word,
        'original_transaction_id' => $faker->word,
        'start_date' => $faker->word,
        'end_date' => $faker->word,
        'latest_receipt' => $faker->word,
        'created_at' => $faker->date('Y-m-d H:i:s'),
        'updated_at' => $faker->date('Y-m-d H:i:s')
    ];
});
