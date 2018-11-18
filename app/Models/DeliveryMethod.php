<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class DeliveryMethod extends Model
{
    protected $guarded = [
        'id', 'created_at', 'updated_at'
    ];

    protected $table = 'delivery_methods';

    public function shop_information()
    {
        return $this->belongsToMany(
            'App\Models\ShopInformation',
            'delivery_method_shop_information',
            'delivery_method_id',
            'shop_information_id');
    }
}
