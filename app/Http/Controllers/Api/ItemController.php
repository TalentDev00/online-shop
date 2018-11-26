<?php

namespace App\Http\Controllers\Api;

use App\Http\Resources\ItemResource;
use App\Models\Item;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;

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

        if (!$request->has('cat_id') || !$request->filled('cat_id')) {
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
                })
                    ->with([
                        'images',
                        'item_variants.item_variant_values',
                        'item_properties'
                    ])
                    ->where('name', 'like', '%'.$request->input('keywords').'%')
                    ->where('price', '>=', $minPrice)
                    ->where('price', '<=', $maxPrice)
                    ->orderBy($sortMethod, $direction)
                    ->get());
        }

        else {
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
                })
                    ->with([
                        'images',
                        'item_variants.item_variant_values',
                        'item_properties'
                    ])
                    ->where('cat_id', '=', $request->input('cat_id'))
                    ->where('price', '>=', $minPrice)
                    ->where('price', '<=', $maxPrice)
                    ->orderBy($sortMethod, $direction)
                    ->get());
        }
    }
}

