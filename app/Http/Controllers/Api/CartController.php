<?php

namespace App\Http\Controllers\Api;

use App\Http\Requests\CartItemRequest;
use App\Models\Cart;
use App\Models\CartItem;
use App\Http\Controllers\Controller;

class CartController extends Controller
{
    public function index(CartItemRequest $request)
    {
        if ($request->has('user_id') && $request->filled('user_id')) {
            $cart = Cart::with('cart_items')->where('user_id', $request->post('user_id'))->first();
            $cartIts = [];
            foreach ($cart->cart_items as $cartIt) {
                if ( $cartIt['item_id'] === $request->post('item_id') ) {
                    $cartIts[] = $cartIt;
                }
            }

            if (count($cartIts) > 0) {
                $cartItem = $cartIts[0];
                if ($request->filled('qty') && intval($request->input('qty')) !== 0) {
                    $cartItem->qty = intval($request->input('qty'));
                    $cartItem->save();
                }
                else {
                    $cart->cart_items()->detach($cartItem);
                    $cartItem->delete();
                }
            }
            else {
                $cartItem = CartItem::create([
                    'qty' => $request->input('qty'),
                    'item_id' => $request->input('item_id')
                ]);
                $cart->cart_items()->attach($cartItem);
            }
        }
    }
}
