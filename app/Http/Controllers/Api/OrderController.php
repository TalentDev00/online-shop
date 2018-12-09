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
        $order->cart_data = serialize($request->input('items'));
        $order->total_price = intval($request->input('total_price'));
        $order->total_discount = intval($request->input('total_discount'));
        $order->final_price = intval($request->input('final_price'));
        $order->save();

        $cart = Auth::user()->cart()->with('vouchers')->first();
        if ($cart->vouchers) {
            foreach($cart->vouchers as $voucher) {
                $cart->vouchers()->detach($voucher['id']);
            }
        }

        $cart->cart_items()->detach($cartItemIds);

        return response([
            'status' => 'success',
            'order' => $order,
        ], 200);


    }

    public function delete($order_id)
    {
        $order = Order::where('user_id', Auth::user()->id)->find($order_id);
        if ($order) {
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
            return new OrderResource(Order::where('user_id', Auth::user()->id)->find($request->get('orderId')));
        }

        if (!$request->has('orderId') && !$request->filled('orderId')) {
            return OrderResource::collection(Order::where('user_id', Auth::user()->id)->get());
        }

        return response([
            'status' => 'failed',
            'message' => 'Order not found'
        ], 404);

    }
}
