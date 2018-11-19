<?php

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class ImagesItemsTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $imagesIds = App\Models\Image::pluck('id')->toArray();
        $items = App\Models\Item::all();

        $items->each(function($item) use ($imagesIds){
            $item->images()->sync(array_random($imagesIds, mt_rand(1,5)));
        });
    }
}
