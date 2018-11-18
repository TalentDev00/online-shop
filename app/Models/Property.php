<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Property extends Model
{
    protected $guarded = [
        'id', 'updated_at', 'created_at'
    ];

    // Relations

    public function products()
    {
        return $this->belongsToMany('App\Models\Product');
    }
}
