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

        return ItemResource::collection(Item::with(['images', 'item_variants.item_variant_values', 'item_properties'])->where('cat_id', '=', $request->input('cat_id'))->get());

    }
}
