<?php

namespace App\Http\Controllers\Api;

use App\Http\Requests\OrderRequest;
use App\Models\CartItem;
use App\Models\DeliveryMethod;
use App\Models\Order;
use App\Models\PaymentMethod;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;

class OrderController extends Controller
{
    public function index(OrderRequest $request)
    {
        $paymentMethod = PaymentMethod::where('name', $request->input('payment_method'))->first();
        $deliveryMethod = DeliveryMethod::where('name', $request->input('delivery_method'))->first();
       // dump($paymentMethod, $deliveryMethod, $request->items);
        $cartItemIds = [];
        foreach ($request->input('items') as $cartItem) {
            $cartItem = CartItem::create([
                'item_id' => $cartItem['item']['id'],
                'qty' => $cartItem['qty']
            ]);
            $cartItemIds[] = $cartItem->id;
        }
        dump($cartItemIds);
        $order = new Order;
        $order->status = $request->input('status');
        $order->payment_method_id = $paymentMethod->id;
        $order->delivery_method_id = $deliveryMethod->id;
        $order->comment = $request->input('comment') ?? null;
        $order->user_id = 1;
        $order->save();
        $order->cart_items()->attach($cartItemIds);

        return response([
            'status' => 'success',
            'data' => $order,
        ], 200);
    }
}
