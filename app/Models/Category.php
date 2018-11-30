<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Kalnoy\Nestedset\NodeTrait;
use Laravel\Scout\Searchable;
use TeamTNT\TNTSearch\Indexer\TNTIndexer;

class Category extends Model
{
    //use NodeTrait;
    use Searchable;

    protected $guarded = [
      'id', 'update_at', 'created_at'
    ];

    public $asYouType = true;

    // Relations

    public function items()
    {
        return $this->hasMany('App\Models\Item', 'cat_id', 'id');
    }

    public function children()
    {
        return $this->hasMany('App\Models\Category', 'parent_id', 'id');
    }

    public function parent()
    {
        return $this->belongsTo('App\Models\Category', 'parent_id');
    }

    public function shop_information()
    {
        return $this->belongsToMany(
            'App\Models\ShopInformation',
            'category_shop_information',
            'category_id',
            'shop_information_id'
        );
    }


  /*  public function generatePath()
    {
        $slug = $this->slug;

        $this->path = $this->isRoot() ? $slug : $this->parent->path.'/'.$slug;

        return $this;
    }

    public function getUrl()
    {
        return '/store/catalog/'.$this->path;
    }*/

    public function searchableAs()
    {
        return 'categories_index';
    }

    public function toSearchableArray()
    {
        $array = $this->only('name');
        $array['nameNgrams'] = utf8_encode((new TNTIndexer)->buildTrigrams($this->name));
        $array[$this->getKeyName()] = $this->getKey();

        return $array;
    }
}
