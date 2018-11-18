<?php

use Illuminate\Database\Seeder;

class DeliveryMethodsShopInformationTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $deliveryMethodsIds = App\Models\DeliveryMethod::pluck('id')->toArray();
        $deliveryMethods = App\Models\DeliveryMethod::all();
        $shopInfo = App\Models\ShopInformation::all();

        $shopInfo->each(function($shopInfo) use ($deliveryMethods){
            $shopInfo->delivery_methods()->sync($deliveryMethods);
        });
    }
}
