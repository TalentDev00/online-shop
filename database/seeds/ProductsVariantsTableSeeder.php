<?php

use Illuminate\Database\Seeder;

class ProductsVariantsTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $variantsIds = App\Models\Variant::pluck('id')->toArray();
        $products = App\Models\Product::all();

        $products->each(function($product) use ($variantsIds){
            $product->variants()->sync(array_random($variantsIds, mt_rand(0,2)));
        });
    }
}
