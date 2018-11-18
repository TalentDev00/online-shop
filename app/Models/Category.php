<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Category extends Model
{
    protected $guarded = [
      'id', 'update_at', 'created_at'
    ];


    // Relations

    public function catalog()
    {
        return $this->belongsTo('App\Models\Catalog');
    }

    public function products()
    {
        return $this->hasMany('App\Models\Product', 'cat_id');
    }
}
