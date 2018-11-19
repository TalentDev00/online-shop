<?php

use Illuminate\Database\Seeder;

class CartItemsOrdersTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $cartItemIds = App\Models\CartItem::pluck('id')->toArray();
        $orders = App\Models\Order::all();

        $orders->each(function($order) use ($cartItemIds){
            $order->cart_items()->sync(array_random($cartItemIds, 3));
        });
    }
}
