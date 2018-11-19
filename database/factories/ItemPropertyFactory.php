<?php

use Faker\Generator as Faker;
/**
 * @var \Illuminate\Database\Eloquent\Factory $factory
 */
$factory->define(App\Models\ItemProperty::class, function (Faker $faker) {
    return [
        'name' => $faker->word,
        'value' => $faker->word
    ];
});