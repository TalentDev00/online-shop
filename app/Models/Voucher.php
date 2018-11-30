<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Voucher extends Model
{
    protected $guarded = [
        'id', 'created_at', 'updated_at'
    ];


    public function users()
    {
        return $this->belongsToMany(
            'App\Models\User',
            'user_voucher',
            'voucher_id',
            'user_id'
        );
    }

    public function items()
    {
        return $this->belongsToMany(
            'App\Models\Item',
            'item_voucher',
            'voucher_id',
            'item_id'
        );
    }

    public function shop_information()
    {
        return $this->belongsToMany(
            'App\Models\ShopInformation',
            'shop_information_voucher',
            'voucher_id',
            'shop_information_id'
        );
    }
}
