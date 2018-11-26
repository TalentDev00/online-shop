<?php

namespace App\Http\Controllers\Api;

use App\Models\Category;
use App\Models\Item;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;

class SearchController extends Controller
{
    public function index(Request $request)
    {
        $categories = Category::search($request->input('keywords'))->get();
        $items = Item::search($request->input('keywords'))
            ->get()
            ->load([
                'images',
                'item_variants.item_variant_values',
                'item_properties'
            ]);





        return $categories->merge($items);
    }
}
