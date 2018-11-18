<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Catalog extends Model
{
    protected $guarded = [
        'id', 'created_at', 'updated_at'
    ];

    // Relations
    public function categories()
    {
        return $this->hasMany('App\Models\Category', 'parent_id');
    }

    public function shop_information()
    {
        return $this->belongsToMany(
            'App\Models\ShopInformation',
            'catalog_shop_information',
            'catalog_id',
            'shop_information_id'
        );
    }

}
