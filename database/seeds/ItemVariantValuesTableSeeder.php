<?php

use Illuminate\Database\Seeder;

class ItemVariantValuesTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $variant = App\Models\ItemVariant::all();

        $variant->each(function($variant){
            $variant->item_variant_values()->saveMany(factory(App\Models\ItemVariantValue::class, mt_rand(2, 4))
                ->create(['item_variant_id' => $variant->id])
            );
        });
    }
}
