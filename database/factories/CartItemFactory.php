<?php

use Faker\Generator as Faker;
/**
 * @var \Illuminate\Database\Eloquent\Factory $factory
 */
$factory->define(App\Models\CartItem::class, function (Faker $faker) {
    return [
        'qty' => mt_rand(2,4)
    ];
});
