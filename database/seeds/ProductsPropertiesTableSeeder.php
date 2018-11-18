<?php

use Illuminate\Database\Seeder;

class ProductsPropertiesTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $products = App\Models\Product::all();
        $propertiesIds = App\Models\Property::pluck('id')->toArray();

        $products->each(function($product) use ($propertiesIds){
            $product->properties()->sync(array_random($propertiesIds, mt_rand(1,4)));
        });
    }
}
