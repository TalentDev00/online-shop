<?php

use Illuminate\Database\Seeder;

class PaymentMethodsShopInformationTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $paymentMethodsIds = App\Models\PaymentMethod::pluck('id')->toArray();
        $paymentMethods = App\Models\PaymentMethod::all();
        $shopInfo = App\Models\ShopInformation::all();

        $shopInfo->each(function($shopInfo) use ($paymentMethods){
            $shopInfo->payment_methods()->sync($paymentMethods);
        });
    }
}
