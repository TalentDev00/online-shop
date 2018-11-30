<?php

use Faker\Generator as Faker;
/**
 * @var \Illuminate\Database\Eloquent\Factory $factory
 */
$factory->define(App\Models\Order::class, function (Faker $faker) {
    $statuses = ['выролнен', 'в обработке', 'отменен'];
    return [
        'status' => array_random($statuses),
        'comment' => $faker->realText(50),
        'delivery_address' => $faker->address,
        'payment_method_id' => mt_rand(1,2),
        'delivery_method_id' => mt_rand(1,2)
    ];
});
