<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Favorite extends Model
{
    protected $guarded = [
        'id', 'updated_at', 'created_at'
    ];
}
