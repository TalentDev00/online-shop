<?php

namespace App\Http\Controllers\Api;

use App\Http\Requests\OrderRequest;
use App\Http\Resources\OrderResource;
use App\Models\CartItem;
use App\Models\DeliveryMethod;
use App\Models\Order;
use App\Models\PaymentMethod;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Auth;

class OrderController extends Controller
{
    public function index(OrderRequest $request)
    {
        $paymentMethod = PaymentMethod::where('name', $request->input('payment_method'))->first();
        $deliveryMethod = DeliveryMethod::where('name', $request->input('delivery_method'))->first();

        $cartItemIds = [];
        foreach ($request->input('items') as $cartItem) {
            $cartItemIds[] = $cartItem['id'];
        }

        $order = new Order;
        $order->status = $request->input('status');
        $order->delivery_address = $request->input('delivery_address');
        $order->payment_method_id = $paymentMethod->id;
        $order->delivery_method_id = $deliveryMethod->id;
        $order->comment = $request->input('comment') ?? null;
        $order->user_id = Auth::user()->id;
        $order->save();
        $order->cart_items()->attach($cartItemIds);
        $cart = Auth::user()->cart()->first();
        $cart->cart_items()->detach($cartItemIds);
        return response([
            'status' => 'success',
            'order' => $order,
        ], 200);
    }

    public function delete($order_id)
    {
        $order = Order::where('user_id', Auth::user()->id)->with('cart_items')->find($order_id);
        if ($order) {
            $cartItems = $order->cart_items;
            $cartItemIds = [];
            foreach ($cartItems as $cartItm) {
                $cartItemIds[] = $cartItm['id'];
            }
            $order->cart_items()->detach($cartItemIds);
            $order->delete();

            return response([
                'status' => 'success',
            ], 200);
        }
        else {
            return response([
                'status' => 'failed',
                'message' => 'Order not found'
            ], 404);
        }
    }

    public function orders(Request $request)
    {
        if ($request->has('orderId') && $request->filled('orderId') && is_numeric($request->get('orderId'))) {
            return new OrderResource(
                Order::where('user_id', Auth::user()->id)
                    ->with(
                        [
                            'cart_items.item.item_properties',
                            'cart_items.item.item_variants.item_variant_values',
                            'cart_items.item.images',
                        ]
                    )
                    ->find($request->get('orderId'))
            );
        }

        if (!$request->has('orderId') && !$request->filled('orderId')) {
            return OrderResource::collection(
                Order::where('user_id', Auth::user()->id)
                    ->with('cart_items.item')
                    ->get()
            );
        }

        return response([
            'status' => 'failed',
            'message' => 'Order not found'
        ], 404);

    }
}
