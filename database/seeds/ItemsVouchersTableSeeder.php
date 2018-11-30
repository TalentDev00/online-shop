<?php

use App\Models\Item;
use App\Models\Voucher;
use Illuminate\Database\Seeder;

class ItemsVouchersTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $vouchers = Voucher::all();
        $items = Item::all();

        $items->each(function($item) use ($vouchers){
            $item->vouchers()->sync($vouchers);
        });

       /* $vouchers->each(function($voucher) use ($items) {
            $voucher->items()->sync($items);
        });*/
    }
}
