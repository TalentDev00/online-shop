<?php

namespace App\Http\Resources;

use Illuminate\Http\Resources\Json\JsonResource;

class ShopInformationResource extends JsonResource
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
            'name' => $this->name,
            'description' => $this->description,
            'logo' => $this->logo,
            'categories' => CategoryResource::collection($this->whenLoaded('categories')),
            'vouchers' => VoucherResource::collection($this->whenLoaded('vouchers')),
            'payment_methods' => $this->payment_methods,
            'delivery_methods' => $this->delivery_methods,
        ];
    }
}
