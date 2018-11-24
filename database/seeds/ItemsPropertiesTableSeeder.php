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
        $propertiesColorsIds = App\Models\ItemProperty::where('name', '=', 'Color')->pluck('id')->toArray();
        $propertiesBrandsIds = App\Models\ItemProperty::where('name', '=', 'Brand')->pluck('id')->toArray();
        $propertiesCountryIds = App\Models\ItemProperty::where('name', '=', 'Country')->pluck('id')->toArray();
        $propertiesSizeIds = App\Models\ItemProperty::where('name', '=', 'Size')->pluck('id')->toArray();
        $items->each(function($item) use ($propertiesColorsIds, $propertiesBrandsIds, $propertiesCountryIds, $propertiesSizeIds){
            $item->item_properties()->sync([
                intval(array_random($propertiesColorsIds)),
                intval(array_random($propertiesBrandsIds)),
                intval(array_random($propertiesCountryIds)),
                intval(array_random($propertiesSizeIds)),
            ]);
        });
    }
}
