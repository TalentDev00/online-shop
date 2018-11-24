<?php

use Illuminate\Database\Seeder;
class ItemPropertiesTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $faker = Faker\Factory::create();
        //factory(\App\Models\ItemProperty::class, 4)->create();
        $colors = ['red', 'blue', 'green', 'black', 'orange', 'yellow', 'white', 'azure', 'gray'];
        $brands = ['adidas', 'rebook', 'nike', 'puma', 'columbia', 'ice-peak', 'sketchers', 'merrel'];
        $mades = ['China', 'USA', 'Italy', 'Germany', 'Poland', 'Indonesia', 'Japan', 'Sweden', 'Denmark', 'UK', 'Russia'];


        for ($i = 0; $i < 10; $i++) {
            App\Models\ItemProperty::create([
                'name' => 'Color',
                'value' => $faker->unique()->colorName
            ]);
        }

        for ($i = 0; $i < 10; $i++) {
            App\Models\ItemProperty::create([
                'name' => 'Brand',
                'value' => $faker->unique()->company
            ]);
        }

        for ($i = 0; $i < 10; $i++) {
            App\Models\ItemProperty::create([
                'name' => 'Country',
                'value' => $faker->unique()->country
            ]);
        }

        for ($i = 0; $i < 10; $i++) {
            App\Models\ItemProperty::create([
                'name' => 'Size',
                'value' => $faker->unique()->numberBetween(25, 45)
            ]);
        }

    }
}
