<?php

use Faker\Generator as Faker;
/**
 * @var \Illuminate\Database\Eloquent\Factory $factory
 */
$factory->define(App\Models\ShopInformation::class, function (Faker $faker) {
    return [
        'name' => $faker->company,
        'description' => $faker->realText(1000),
        'logo' => $faker->image(public_path('images'), 400, 400, null, false),
    ];
});
