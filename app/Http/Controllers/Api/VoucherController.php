<?php

namespace App\Http\Controllers\Api;

use App\Models\Voucher;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Auth;

class VoucherController extends Controller
{
    public function index(Request $request)
    {
        if ($request->has('voucher') && $request->filled('voucher')) {
            $voucher = Voucher::where('code', $request->post('voucher'))->with('users')->first();
            $authUser = Auth::user();

            if ($voucher) {
                $found = [];
                foreach($voucher->users as $user) {
                    if ($user['id'] === $authUser->id) {
                        $found[] = $user;
                    }
                }

                if (count($found) > 0 && ($voucher->type === 2 || $voucher->type === 3)) {
                    if ($voucher->expires_at !== Null) {
                        $rightNow = date('Y-m-d H:i:s');
                        $startPromoDate = $voucher->starts_at;
                        $endPromoDate = $voucher->expires_at;

                        if ($rightNow < $startPromoDate || $rightNow > $endPromoDate) {
                            return response([
                                'status' => 'failed',
                                'error' => [
                                    'Промокод не активен.'
                                ]
                            ], 400);
                        }
                    }

                    if ($voucher->max_uses === $voucher->uses && $voucher->max_uses !== Null) {
                        return response([
                            'status' => 'failed',
                            'error' => [
                                'Промокод уже использован.'
                            ]
                        ], 400);
                    }

                    if ($voucher->max_uses_user === 0 || $voucher->max_uses_user === Null) {
                        return response([
                            'status' => 'failed',
                            'error' => [
                                'Промокод уже использован.'
                            ]
                        ], 400);
                    }

                    if ($voucher->max_uses !== null && $voucher->max_uses !== 0) {
                        $voucher->max_uses--;
                    }

                    $voucher->uses++;
                    $user->vouchers()->detach($voucher->id);
                    $cart = $user->cart;
                    $cart->vouchers()->attach($voucher->id);
                    $voucher->save();

                    return response([
                        'status' => 'success',
                        'voucher' => $voucher
                    ], 200);
                }
                else {
                    return response([
                        'status' => 'failed',
                        'error' => [
                            'Промокод уже использован.'
                        ]
                    ], 400);
                }
            }
            else {
                return response([
                    'status' => 'failed',
                    'error' => [
                        'Промокод не найден.'
                    ]
                ], 400);
            }
        }

        return response([
            'status' => 'failed',
            'error' => [
                'Промокод не найден.'
            ]
        ], 400);

    }
}
