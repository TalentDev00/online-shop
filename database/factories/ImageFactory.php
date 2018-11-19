<?php

use Faker\Generator as Faker;
/**
 * @var \Illuminate\Database\Eloquent\Factory $factory
 */
$factory->define(App\Models\Image::class, function (Faker $faker) {
    return [
        'small' => $faker->image(public_path('images'), 100, 100, null, false),
        'large' => $faker->image(public_path('images'), 400, 400, null, false)
         /*'small' => $faker->word,
        'large' => $faker->word*/
    ];
});
