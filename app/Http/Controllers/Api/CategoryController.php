<?php

namespace App\Http\Controllers\Api;

use App\Http\Resources\CategoryResource;
use App\Http\Resources\ItemResource;
use App\Http\Resources\ShopInformationResource;
use App\Models\Category;
use App\Models\Item;
use App\Models\ShopInformation;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;


class CategoryController extends Controller
{
/*    public function index($path = Null)
    {

        if ($path === Null) {
            return CategoryResource::collection(Category::all()->where('parent_id', Null));
        }

        $path = explode('/', $path);

        if (count($path) === 1) {
            return new CategoryResource(Category::with('children')->find($path[0]));
        }

        if (count($path) === 2) {
            return ItemResource::collection((Item::with(['images', 'item_variants.item_variant_values', 'item_properties', 'category']))
                ->where('cat_id', $path[1])->get());

        }

        //return new CategoryResource(Category::with('children')->find($path[count($path) - 1]));

    }*/

    public function index()
    {
        return new ShopInformationResource(ShopInformation::with(['categories', 'vouchers'])->first());
    }

    public function show(Request $request, $path = Null)
    {
        if ($path === null && !$request->has('path')) {
            return CategoryResource::collection(Category::all()->where('parent_id', Null));
        }

        if ($request->has('path')) {
            $category = Category::where('path', '=', $request->path)->firstOrFail();
            return CategoryResource::collection(Category::all()->where('parent_id', $category->id));
        }
        /*$category = Category::where('path', '=', $path)->firstOrFail();

        dump($category);
        return CategoryResource::collection(Category::all()->where('parent_id', $category->id));*/
        //return new CategoryResource(Category::where('path', '=', $path)->firstOrFail());
    }






}
