<?php

namespace App\Http\Resources;

use Illuminate\Http\Resources\Json\JsonResource;

class OrderResource extends JsonResource
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
            'status' => $this->status,
            'delivery_address' => $this->delivery_address,
            'comment' => $this->comment,
            'cart_items' => CartItemResource::collection($this->whenLoaded('cart_items')),
        ];
    }
}
