<?php

use Faker\Generator as Faker;
/**
 * @var \Illuminate\Database\Eloquent\Factory $factory
 */
$factory->define(App\Models\Item::class, function (Faker $faker) {
    $array = [
        0, 50.00, 100.00, 150.00
    ];
    return [
        'name' => $faker->firstName,
        'price' => mt_rand(300, 3000),
        'discount' => array_rand($array)

    ];
});
