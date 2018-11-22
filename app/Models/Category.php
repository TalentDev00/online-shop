<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Kalnoy\Nestedset\NodeTrait;

class Category extends Model
{
    use NodeTrait;

    protected $guarded = [
      'id', 'update_at', 'created_at'
    ];


    // Relations

    public function items()
    {
        return $this->hasMany('App\Models\Item', 'cat_id', 'id');
    }

  /*  public function children()
    {
        return $this->hasMany('App\Models\Category', 'parent_id', 'id');
    }

    public function parent()
    {
        return $this->belongsTo('App\Models\Category', 'parent_id');
    }*/

    public function shop_information()
    {
        return $this->belongsToMany(
            'App\Models\ShopInformation',
            'category_shop_information',
            'category_id',
            'shop_information_id'
        );
    }


    public function generatePath()
    {
        $slug = $this->slug;

        $this->path = $this->isRoot() ? $slug : $this->parent->path.'/'.$slug;

        return $this;
    }

    public function getUrl()
    {
        return '/store/catalog/'.$this->path;
    }
}
