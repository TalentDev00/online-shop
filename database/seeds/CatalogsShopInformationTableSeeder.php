<?php

use Illuminate\Database\Seeder;

class CatalogsShopInformationTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $catalogIds = App\Models\Catalog::pluck('id')->toArray();
        $shopInfo = App\Models\ShopInformation::all();

        $shopInfo->each(function($shopInfo) use ($catalogIds){
            $shopInfo->catalogs()->sync($catalogIds);
        });
    }
}
