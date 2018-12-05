<?php

namespace App\Http\Controllers;

use App\Http\Requests\RegisterFormRequest;
use App\Http\Resources\UserResource;
use App\Models\Cart;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Tymon\JWTAuth\Facades\JWTAuth;

class AuthController extends Controller
{
    public function register(RegisterFormRequest $request)
    {
        $user = new User;
        $user->email = $request->email;
        $user->password = bcrypt($request->password);
        $user->save();

        Cart::make()->user()->associate($user)->save();

        return response([
            'status' => 'success',
            'data' => $user
        ], 200);
    }

    /**
     * @param Request $request
     * @return \Illuminate\Contracts\Routing\ResponseFactory|\Illuminate\Http\Response
     */
    public function login(Request $request)
    {
        $credentials = $request->only('email', 'password');

        if ( ! $token = JWTAuth::attempt($credentials)) {
            return response([
                'status' => 'error',
                //'error' => 'invalid.credentials',
                'errors' => [
                    'email' => ['Неверные учетные данные'],
                    'password' => ['Неверные учетные данные']
                ],
                //'msg' => 'Неверные учетные данные'
            ], 400);
        }
        return response([
            'status' => 'success',
        ])->header('Authorization', $token);
    }

    public function user(Request $request)
    {
        //$user = User::with(['cart', 'orders:id', 'favorites:item_id'])->find(Auth::user()->id);
        $user = new UserResource(User::with(
            [
                'cart.cart_items.item.item_properties',
                'cart.cart_items.item.item_variants.item_variant_values',
                'cart.cart_items.item.images',
                'favorites',
            ]
        )->find(Auth::user()->id));

        return response([
            'status' => 'success',
            'data' => $user
        ]);
    }

    public function refresh()
    {
        return response([
            'status' => 'success'
        ]);
    }

    public function logout()
    {
        JWTAuth::invalidate();
        return response([
            'status' => 'success',
            'msg' => 'Logged out Successfully.'
        ], 200);
    }
}
