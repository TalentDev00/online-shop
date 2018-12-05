<?php

namespace App\Http\Resources;

use App\Models\Item;
use Illuminate\Http\Resources\Json\JsonResource;

class CartItemResource extends JsonResource
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
           'qty' => $this->qty,
         /*  'item' => new ItemResource(Item::with([
               'images',
               'item_variants.item_variant_values',
               'item_properties'
           ])->find($this->item_id))*/
            'item' => new ItemResource($this->whenLoaded('item'))
          //'item_id' => $this->item_id
        ];
    }
}
