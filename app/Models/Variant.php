<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Variant extends Model
{
    protected $guarded = [
        'id', 'updated_at', 'created_at'
    ];

    // Relations
    public function values()
    {
        return $this->hasMany('App\Models\Value');
    }

    public function products()
    {
        return $this->belongsToMany('App\Models\Product');
    }
}
