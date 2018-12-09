<?php

namespace App\Http\Resources;

use Illuminate\Http\Resources\Json\JsonResource;

class UserResource extends JsonResource
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
            'phone' => $this->phone,
            'address' => $this->address,
            'email' => $this->email,
            'cart' => new CartResource($this->whenLoaded('cart')),
            'orders' => OrderResource::collection($this->whenLoaded('orders')),
            'favorites' => FavoriteResource::collection($this->whenLoaded('favorites')),
        ];
    }
}
