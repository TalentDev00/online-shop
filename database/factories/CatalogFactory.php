<?php

use Faker\Generator as Faker;
use Faker\Factory;

$faker = Factory::create('ru_RU');
/**
 * @var \Illuminate\Database\Eloquent\Factory $factory
 */
$factory->define(App\Models\Catalog::class, function (Faker $faker) {
    return [
        'name' => $faker->word
    ];
});
