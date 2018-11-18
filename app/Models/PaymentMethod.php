<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class PaymentMethod extends Model
{
    protected $guarded = [
        'id', 'created_at', 'updated_at'
    ];

    protected $table = 'payment_methods';

    // Relations

    public function shop_information()
    {
        return $this->belongsToMany(
            'App\Models\ShopInformation',
            'payment_method_shop_information',
            'payment_method_id',
            'shop_information_id'
        );
    }
}
