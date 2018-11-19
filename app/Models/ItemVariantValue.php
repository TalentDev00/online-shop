<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class ItemVariantValue extends Model
{
    protected $guarded = [
        'id', 'updated_at', 'created_at'
    ];

    // Relations

    public function item_variant()
    {
        return $this->belongsTo('App\Models\ItemVariant');
    }
}
