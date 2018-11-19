<?php

use Illuminate\Database\Seeder;

class ItemsItemVariantsTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $variantsIds = App\Models\ItemVariant::pluck('id')->toArray();
        $items = App\Models\Item::all();

        $items->each(function($item) use ($variantsIds){
            $item->item_variants()->sync(array_random($variantsIds, mt_rand(0,2)));
        });
    }
}
