<?php

use Illuminate\Database\Seeder;

class CategoriesShopInformationTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $categoryIds = App\Models\Category::pluck('id')->toArray();
        $shopInfo = App\Models\ShopInformation::all();

        $shopInfo->each(function($shopInfo) use ($categoryIds){
            $shopInfo->categories()->sync($categoryIds);
        });
    }
}
