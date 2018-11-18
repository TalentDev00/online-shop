<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Value extends Model
{
    protected $guarded = [
        'id', 'updated_at', 'created_at'
    ];

    // Relations
    public function variant()
    {
        return $this->belongsTo('App\Models\Variant');
    }
}
