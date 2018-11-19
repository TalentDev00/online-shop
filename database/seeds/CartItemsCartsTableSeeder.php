<?php

use Illuminate\Database\Seeder;

class CartItemsCartsTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $cartItemIds = App\Models\CartItem::pluck('id')->toArray();
        $carts = App\Models\Cart::all();

        $carts->each(function($cart) use ($cartItemIds) {
            $cart->cart_items()->sync(array_random($cartItemIds, 2));
        });
    }
}
