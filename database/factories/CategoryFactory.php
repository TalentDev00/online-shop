<?php

use Faker\Generator as Faker;
/**
 * @var \Illuminate\Database\Eloquent\Factory $factory
 */
$factory->define(App\Models\Category::class, function (Faker $faker) {
    $word = $faker->word;
    return [
        'name' => $word,
        //'slug' => $word,
        'parent_id' => null
    ];
});

/*$factory->state(App\Models\Category::class, 'children', function (Faker $faker) {
    return [
        'parent_id' => function () {
            return factory('App\Models\Category')->create()->id;
        }
    ];
});*/
