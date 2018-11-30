<?php

namespace App\Http\Resources;

use Illuminate\Http\Resources\Json\JsonResource;

class VoucherResource extends JsonResource
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
            'code' => $this->code,
            'name' => $this->name,
            'image' => $this->image,
            'description' => $this->description,
            'uses' => $this->uses,
            'max_uses' => $this->max_uses,
            'max_uses_user' => $this->max_uses_user,
            'type' => $this->type,
            'discount_amount' => $this->discount_amount,
            'is_fixed' => $this->is_fixed,
            'starts_at' => $this->starts_at,
            'expires_at' => $this->expires_at
        ];
    }
}
