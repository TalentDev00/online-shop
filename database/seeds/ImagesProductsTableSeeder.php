<?php

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class ImagesProductsTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $imagesIds = App\Models\Image::pluck('id')->toArray();
        $products = App\Models\Product::all();

        $products->each(function($product) use ($imagesIds){
            $product->images()->sync(array_random($imagesIds, mt_rand(1,5)));
        });
    }
}
