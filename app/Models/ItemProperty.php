<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class ItemProperty extends Model
{
    protected $guarded = [
        'id', 'updated_at', 'created_at'
    ];

    // Relations

    public function items()
    {
        return $this->belongsToMany('App\Models\Item');
    }
}
