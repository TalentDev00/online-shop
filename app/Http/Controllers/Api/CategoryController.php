<?php

namespace App\Http\Controllers\Api;

use App\Http\Resources\CategoryResource;
use App\Http\Resources\ItemResource;
use App\Models\Category;
use App\Models\Item;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;


class CategoryController extends Controller
{
     public function index($path = Null)
     {
         if ($path === Null) {
             return CategoryResource::collection(Category::all()->where('parent_id', Null));
         }

         $path = explode('/', $path);
         //dump($path);

         if (count($path) === 1) {
             return new CategoryResource(Category::with('children')->find($path[0]));
         }

         if (count($path) === 2) {
             return ItemResource::collection((Item::with(['images', 'item_variants.item_variant_values', 'item_properties', 'category']))
                ->where('cat_id', $path[1])->get());

         }

     }










}
