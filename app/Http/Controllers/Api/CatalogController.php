<?php

namespace App\Http\Controllers\Api;

use App\Http\Resources\CatalogResource;
use App\Http\Resources\ProductResource;
use App\Models\Catalog;
use App\Models\Product;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;


class CatalogController extends Controller
{
     public function index()
     {
         return CatalogResource::collection(Catalog::all());
     }

     public function subcatalogIndex($catalog_id)
     {
         /*$subcatalog = Catalog::with('categories')->find($catalog_id);
         return $subcatalog->toArray();*/

         return new CatalogResource(Catalog::with('categories')->find($catalog_id));
     }

     public function sectionIndex($catalog_id, $section_id)
     {
         /*$products = Product::with(['images', 'variants.values', 'properties'])
             ->where('cat_id',$section_id)->get();
         return $products->toArray();*/

         //return new ProductResource(Product::with(['categories', 'images', 'variants', 'properties'])->where('cat_id', $section_id)->find());
         return ProductResource::collection(Product::with(['images', 'variants.values', 'properties'])->where('cat_id', $section_id)->get());
     }
}
