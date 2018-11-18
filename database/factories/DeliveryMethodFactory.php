<?php

use Faker\Generator as Faker;
/**
 * @var \Illuminate\Database\Eloquent\Factory $factory
 */
$factory->define(App\Models\DeliveryMethod::class, function (Faker $faker) {
    return [
        'name' => $faker->company
    ];
});
