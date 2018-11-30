<?php

namespace App\Http\Controllers\Api;

use App\Http\Resources\ItemResource;
use App\Models\Item;
use App\Models\User;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Auth;
use Tymon\JWTAuth\Facades\JWTAuth;

class ItemController extends Controller
{
    public function index(Request $request)
    {
        if ($request->input('sort') === 'price_asc') {
            $sortMethod = 'price';
            $direction = 'asc';
        }
        else if ($request->input('sort') === 'price_desc') {
            $sortMethod = 'price';
            $direction = 'desc';
        }

        else if ($request->input('sort') === 'rating') {
            $sortMethod = 'rating';
            $direction = 'desc';
        }

        else if ($request->input('sort') === 'discount') {
            $sortMethod = 'discount';
            $direction = 'desc';
        }

        else if ($request->input('sort') === 'new') {
            $sortMethod = 'created_at';
            $direction = 'desc';
        }

        else {
            $sortMethod = 'created_at';
            $direction = 'asc';
        }

        if (!$request->has('min') || !$request->has('max') || !$request->filled('min') || !$request->filled('max')) {
            $minPrice = 0;
            $maxPrice = INF;
        }

        else {
            $minPrice = $request->input('min');
            $maxPrice = $request->input('max');
        }

        if ($request->has('filters')) {
            $filters = $request->input('filters');
        }
        else {
            $filters = Null;
        }

        return ItemResource::collection(
            Item::whereHas(
                'item_properties', function($query) use ($filters){
                    if ($filters !== Null) {
                        //dd(json_decode($filters));
                        $filters = json_decode($filters, true);
                        $i = 0;
                        foreach ($filters as $filter) {
                            if ($i === 0) {
                                $query->where('name', $filter["name"])
                                    ->where('value', $filter["value"]);
                            }
                            else {
                                $query->orWhere('name', $filter["name"])
                                    ->where('value', $filter["value"]);
                            }
                            $i++;
                        }
                    }

                }
            )

                ->with([
                    'images',
                    'item_variants.item_variant_values',
                    'item_properties'
                ])
                ->where(
                    !$request->has('cat_id') || !$request->filled('cat_id') ? 'name' : 'cat_id',
                    !$request->has('cat_id') || !$request->filled('cat_id') ? 'like' : '=',
                    !$request->has('cat_id') || !$request->filled('cat_id') ? ('%'.$request->input('keywords').'%') : $request->input('cat_id'))
                ->where('price', '>=', $minPrice)
                ->where('price', '<=', $maxPrice)
                ->orderBy($sortMethod, $direction)
                ->get());

    }

    public function favoriteItem(Request $request)
    {
        $user = User::find($request->input('user_id'));
        $user->favorites()->attach($request->input('item_id'));

        return response([
            'status' => 'success',
        ], 200);
    }

    public function unFavoriteItem(Request $request)
    {
        Auth::user()->favorites()->detach($request->input('item_id'));

        return response([
            'status' => 'success',
        ], 200);
    }

    public function favorite(Request $request)
    {
        if ($request->post('item_id') && $request->filled('item_id') && $request->post('user_id') && $request->filled('user_id')) {
            $user = User::find($request->post('user_id'));
            $favoriteItem = $user->favorites()->where('item_id', $request->post('item_id'))->first();
            if ($favoriteItem) {
                $user->favorites()->detach($favoriteItem->id);
            }
            else {
                $user->favorites()->attach($request->post('item_id'));
            }

            return response([
                'status' => 'success',
            ], 200);
        }

        if ($request->post('items') && $request->filled('items') && $request->post('user_id') && $request->filled('user_id')) {
            $user = User::find($request->post('user_id'));
            $user->favorites()->sync(json_decode($request->post('items'), true));
        }

        if ($request->input('sort') === 'price_asc') {
            $sortMethod = 'price';
            $direction = 'asc';
        }
        else if ($request->input('sort') === 'price_desc') {
            $sortMethod = 'price';
            $direction = 'desc';
        }

        else if ($request->input('sort') === 'rating') {
            $sortMethod = 'rating';
            $direction = 'desc';
        }

        else if ($request->input('sort') === 'discount') {
            $sortMethod = 'discount';
            $direction = 'desc';
        }

        else if ($request->input('sort') === 'new') {
            $sortMethod = 'created_at';
            $direction = 'desc';
        }

        else {
            $sortMethod = 'created_at';
            $direction = 'asc';
        }

        if (!$request->has('min') || !$request->has('max') || !$request->filled('min') || !$request->filled('max')) {
            $minPrice = 0;
            $maxPrice = INF;
        }

        else {
            $minPrice = $request->input('min');
            $maxPrice = $request->input('max');
        }

        if ($request->has('filters')) {
            $filters = $request->input('filters');
        }
        else {
            $filters = Null;
        }

        return ItemResource::collection(
            Item::whereHas(
                'item_properties',
                function($query) use ($filters){
                    if ($filters !== Null) {
                        $filters = json_decode($filters, true);
                        $i = 0;
                        foreach ($filters as $filter) {
                            if ($i === 0) {
                                $query->where('name', $filter["name"])
                                    ->where('value', $filter["value"]);
                            }
                            else {
                                $query->orWhere('name', $filter["name"])
                                    ->where('value', $filter["value"]);
                            }
                            $i++;
                        }
                    }

                }
            )
            ->whereHas('favorites', function($query) use ($request) {
                $query->where('user_id', $request->input('user_id'));
            })
            ->with([
                'images',
                'item_variants.item_variant_values',
                'item_properties'
            ])
            ->where('price', '>=', $minPrice)
            ->where('price', '<=', $maxPrice)
            ->orderBy($sortMethod, $direction)
            ->get());
    }

}

