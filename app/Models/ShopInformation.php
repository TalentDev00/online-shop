<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class ShopInformation extends Model
{
    protected $guarded = [
        'id', 'created_at', 'updated_at'
    ];

    protected $table = 'shop_information';

    // Relations
    public function payment_methods()
    {
        return $this->belongsToMany(
            'App\Models\PaymentMethod',
            'payment_method_shop_information',
            'shop_information_id',
            'payment_method_id'
        );
    }

    public function delivery_methods()
    {
        return $this->belongsToMany(
            'App\Models\DeliveryMethod',
            'delivery_method_shop_information',
            'shop_information_id',
            'delivery_method_id'
        );
    }

    public function categories()
    {
        return $this->belongsToMany(
            'App\Models\Category',
            'category_shop_information',
            'shop_information_id',
            'category_id'
        );
    }
}
