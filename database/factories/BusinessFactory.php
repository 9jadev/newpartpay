<?php

/** @var \Illuminate\Database\Eloquent\Factory $factory */

use App\Business;
use Faker\Generator as Faker;

$factory->define(Business::class, function (Faker $faker) {
    return [
        'user_id' => 1,
        'business_name' => $faker->company,
        'business_type' => 'Seller',
        'business_about' => $faker->text(200),
        'business_serial' => $faker->randomNumber(2),
        'business_image' => $faker->imageUrl(400, 400, 'cats'),
        'business_approved' => false,
        'account_balance' => $faker->numberBetween(1000, 10000),
        'account_total' => $faker->numberBetween(10000, 1000000),
        'bank_name' => $faker->company,
        'account_number' => $faker->bankAccountNumber,
    ];
});
