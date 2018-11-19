<?php

use Illuminate\Database\Seeder;

class CartItemsTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $itemIds = App\Models\Item::pluck('id')->toArray();

        for ($i = 0; $i < 4; $i++) {
            App\Models\CartItem::create([
                'qty' => mt_rand(1,4),
                'item_id' => array_random($itemIds)
            ]);
        }
    }
}
