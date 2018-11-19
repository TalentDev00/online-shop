<?php

use Illuminate\Database\Seeder;

class ItemsPropertiesTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $items = App\Models\Item::all();
        $propertiesIds = App\Models\ItemProperty::pluck('id')->toArray();

        $items->each(function($item) use ($propertiesIds){
            $item->item_properties()->sync(array_random($propertiesIds, mt_rand(1,4)));
        });
    }
}
