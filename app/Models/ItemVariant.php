<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class ItemVariant extends Model
{
    protected $guarded = [
        'id', 'updated_at', 'created_at'
    ];

    // Relations

    public function items()
    {
        return $this->belongsToMany('App\Models\Item');
    }

    public function item_variant_values()
    {
        return $this->hasMany('App\Models\ItemVariantValue');
    }
}
