<?php

namespace App\Http\Resources;

use App\Models\Category;
use Illuminate\Http\Resources\Json\JsonResource;

class ItemResource extends JsonResource
{
    /**
     * Transform the resource into an array.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return array
     */
    public function toArray($request)
    {
        return [
            'id' => $this->id,
            'name' => $this->name,
            'cat_id' => $this->cat_id,
            'price' => $this->price,
            'discount' => $this->discount,
            'images' => ImageResource::collection($this->whenLoaded('images')),
            'properties' => ItemPropertyResource::collection($this->whenLoaded('item_properties')),
            'variants' => ItemVariantResource::collection($this->whenLoaded('item_variants')),
            'category' => new CategoryResource($this->whenLoaded('category'))
        ];
    }
}
