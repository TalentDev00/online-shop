<?php

namespace App\Http\Controllers\Api;

use App\Http\Requests\CartItemRequest;
use App\Http\Resources\CartResource;
use App\Models\Cart;
use App\Models\CartItem;
use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class CartController extends Controller
{
    public function index(Request $request)
    {
        return new CartResource(Cart::with(
            [
                'cart_items.item.images',
                'cart_items.item.item_properties',
                'cart_items.item.item_variants.item_variant_values',
                'vouchers:voucher_id,is_fixed,discount_amount,type'
            ]
        )->where('user_id', Auth::user()->id)->first());
    }

    public function syncItem(CartItemRequest $request)
    {
        $cart = Cart::with('cart_items')->where('user_id', Auth::user()->id)->first();
        $cartIts = [];
        foreach ($cart->cart_items as $cartIt) {
            if ( $cartIt['item_id'] === $request->post('item_id') ) {
                $cartIts[] = $cartIt;
            }
        }
        if (count($cartIts) > 0) {
            $cartItem = $cartIts[0];
            if ($request->filled('qty') && intval($request->post('qty')) !== 0) {
                $cartItem->qty = intval($request->post('qty'));
                $cartItem->save();
            }
            else {
                $cart->cart_items()->detach($cartItem->id);
                $cartItem->delete();
            }
        }
        else {
            $cartItem = CartItem::create([
                'qty' => $request->post('qty'),
                'item_id' => $request->post('item_id')
            ]);
            $cart->cart_items()->attach($cartItem->id);
        }

    }

    public function syncCart(Request $request)
    {

        if ($request->has('syncItems') && $request->filled('syncItems')) {
            $cart = Cart::with('cart_items')->where('user_id', Auth::user()->id)->first();
            $cartItmsIds = [];
            foreach ($request->post('syncItems') as $syncItm) {
                $cartItm = CartItem::create([
                    'qty' => $syncItm['qty'],
                    'item_id' => $syncItm['item']['id']
                ]);
                $cartItmsIds[] = $cartItm->id;
            }
            $cart->cart_items()->sync($cartItmsIds);

            return response([
                'status' => 'success'
            ], 200);
        }

        return response([
            'status' => 'failed',
            'msg' => 'Nothing to sync'
        ], 400);
    }

}
