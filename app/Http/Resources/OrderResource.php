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
            'total_price' => $this->total_price,
            'total_discount' => $this->total_discount,
            'final_price' => $this->final_price,
            'cart_data' => unserialize($this->cart_data),
            'updated_at' => getRusDate($this->updated_at, 'd %MONTH% Y')
        ];
    }
}
