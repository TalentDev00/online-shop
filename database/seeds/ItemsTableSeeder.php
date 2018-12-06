<?php

use Illuminate\Database\Seeder;

class ItemsTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $faker = Faker\Factory::create();
        $array = [
            0, 50.00, 100.00, 150.00
        ];

        for ($i = 0; $i < 150; $i++) {
            App\Models\Item::create([
                'cat_id' => 1,
                'name' => $faker->firstName,
                'price' => mt_rand(300, 3000),
                'discount' => array_rand($array),
                'rating' => mt_rand(0, 5)
            ]);
        }
    }
}
