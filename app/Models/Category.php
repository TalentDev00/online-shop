<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Category extends Model
{
    protected $guarded = [
      'id', 'update_at', 'created_at'
    ];


    // Relations

    public function items()
    {
        return $this->hasMany('App\Models\Item', 'cat_id', 'id');
    }

    public function children()
    {
        return $this->hasMany('App\Models\Category', 'parent_id', 'id');
    }

    public function parent()
    {
        return $this->belongsTo('App\Models\Category', 'parent_id');
    }

    public function shop_information()
    {
        return $this->belongsToMany(
            'App\Models\ShopInformation',
            'category_shop_information',
            'category_id',
            'shop_information_id'
        );
    }
}
