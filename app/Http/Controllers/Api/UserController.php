<?php

namespace App\Http\Controllers\Api;

use App\Http\Requests\UserRequest;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Auth;

class UserController extends Controller
{
    public function index(UserRequest $request)
    {
        $user = Auth::user();
        $user->name = $request->post('name');
        $user->email = $request->post('email');
        $user->phone = $request->post('phone');
        $user->address = $request->post('address');
        $user->password = bcrypt($request->post('password'));
        $user->save();

        return response([
            'status' => 'success',
            'data' => $user
        ], 200);
    }
}
