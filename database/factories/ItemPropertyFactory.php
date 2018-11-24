<?php

use Faker\Generator as Faker;
/**
 * @var \Illuminate\Database\Eloquent\Factory $factory
 */
$factory->define(App\Models\ItemProperty::class, function (Faker $faker) {
    $colors = ['red', 'blue', 'green', 'black', 'orange', 'yellow', 'white', 'azure', 'gray'];
    $value = $faker->colorName . ', ' . $faker->colorName . ', ' . $faker->colorName;
    $colorStr = implode(', ', array_random($colors, mt_rand(2, 5)));
    return [
        'name' => $faker->word,
        'value' => $colorStr
    ];
});
