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


      /*  if ($request->input('sort') === 'price_asc') {
            return ItemResource::collection(Item::with(['images', 'item_variants.item_variant_values', 'item_properties'])->where('cat_id', '=', $request->input('cat_id'))->orderBy('price')->get());
        }

        if ($request->input('sort') === 'price_desc') {
            return ItemResource::collection(Item::with(['images', 'item_variants.item_variant_values', 'item_properties'])->where('cat_id', '=', $request->input('cat_id'))->orderBy('price', 'desc')->get());
        }

        if ($request->input('sort') === 'rating') {
            return ItemResource::collection(Item::with(['images', 'item_variants.item_variant_values', 'item_properties'])->where('cat_id', '=', $request->input('cat_id'))->orderBy('rating', 'desc')->get());
        }

        if ($request->input('sort') === 'discount') {
            return ItemResource::collection(Item::with(['images', 'item_variants.item_variant_values', 'item_properties'])->where('cat_id', '=', $request->input('cat_id'))->orderBy('discount', 'desc')->get());
        }

        if ($request->input('sort') === 'new') {
            return ItemResource::collection(Item::with(['images', 'item_variants.item_variant_values', 'item_properties'])->where('cat_id', '=', $request->input('cat_id'))->orderBy('created_at', 'desc')->get());
        }

        if ($request->input('minPrice') !== '' && $request->input('maxPrice') !== '') {
            return ItemResource::collection(
                Item::with(['images', 'item_variants.item_variant_values', 'item_properties'])
                    ->where('cat_id', '=', $request->input('cat_id'))
                    ->where('price', '>=', $request->input('minPrice'))
                    ->where('price', '<=', $request->input('maxPrice'))
                    ->get()
            );
        }*/
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


        return ItemResource::collection(
            Item::whereHas(
                'item_properties', function($query) {
                    $query->where('name', 'Color');
                    $query->where('value', 'Aqua');
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
/*2903-2940*/
