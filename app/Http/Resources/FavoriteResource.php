<?php

namespace App\Http\Resources;

use App\Models\Item;
use Illuminate\Http\Resources\Json\JsonResource;

class FavoriteResource extends JsonResource
{
    /**
     * Transform the resource into an array.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return array
     */
    public function toArray($request)
    {
        $item = new ItemResource(Item::with([
            'images',
            'item_variants.item_variant_values',
            'item_properties'
        ])->find($this->id));

        return [
            'id' => $item->id,
            'name' => $item->name,
            'cat_id' => $item->cat_id,
            'price' => $item->price,
            'discount' => $item->discount,
            'images' => ImageResource::collection($item->whenLoaded('images')),
            'properties' => ItemPropertyResource::collection($item->whenLoaded('item_properties')),
            'variants' => ItemVariantResource::collection($item->whenLoaded('item_variants')),
            'category' => new CategoryResource($item->whenLoaded('category'))
        ];
    }
}
