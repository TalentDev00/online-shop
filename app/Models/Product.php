<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Product extends Model
{
    protected $guarded = [
        'id', 'updated_at', 'created_at'
    ];

    // Relations
    public function categories()
    {
        return $this->belongsTo('App\Models\Category');
    }

    public function images()
    {
        return $this->belongsToMany('App\Models\Image');
    }

    public function properties()
    {
        return $this->belongsToMany('App\Models\Property');
    }

    public function variants()
    {
        return $this->belongsToMany('App\Models\Variant');
    }

}
