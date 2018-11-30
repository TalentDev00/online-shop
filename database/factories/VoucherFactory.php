<?php

use Faker\Generator as Faker;
/**
 * @var \Illuminate\Database\Eloquent\Factory $factory
 */
$factory->define(App\Models\Voucher::class, function (Faker $faker) {
    return [
        'name' => $faker->word,
        'type' => mt_rand(1,3),
        'discount_amount' => $faker->numberBetween(50, 100),
    ];
});
