<?php

use Illuminate\Database\Seeder;

class ShopInformationVouchersTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $vouchers = App\Models\Voucher::all();
        $shopInfo = App\Models\ShopInformation::all();

        $shopInfo->each(function($shopInfo) use ($vouchers){
            $shopInfo->vouchers()->sync($vouchers);
        });
    }
}
