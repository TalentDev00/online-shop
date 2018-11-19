<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Item extends Model
{
    protected $guarded = [
        'id', 'updated_at', 'created_at'
    ];

    // Relations
    public function category()
    {
        return $this->belongsTo('App\Models\Category', 'cat_id', 'id');
    }

    public function images()
    {
        return $this->belongsToMany('App\Models\Image');
    }

    public function item_properties()
    {
        return $this->belongsToMany('App\Models\ItemProperty');
    }

    public function item_variants()
    {
        return $this->belongsToMany('App\Models\ItemVariant');
    }

    public function orders()
    {
        return $this->belongsToMany('App\Models\Order');
    }

    public function cart_item()
    {
        return $this->belongsTo('App\Models\CartItem');
    }

}
