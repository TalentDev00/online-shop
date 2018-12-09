<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Order extends Model
{
    protected $guarded = [
        'id', 'created_at', 'updated_at'
    ];

    // Relations

    public function user()
    {
        return $this->belongsTo('App\Models\User');
    }
}
