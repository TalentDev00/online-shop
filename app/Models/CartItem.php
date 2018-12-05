<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class CartItem extends Model
{
    protected $guarded = [
        'id', 'updated_at', 'created_at'
    ];

    // Relations
    public function item()
    {
        return $this->belongsTo('App\Models\Item');
    }

    public function orders()
    {
        return $this->belongsToMany('App\Models\Orders');
    }

    public function carts()
    {
        return $this->belongsToMany('App\Models\Cart');
    }
}
