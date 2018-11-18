<?php

use Illuminate\Database\Seeder;

class ValuesTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $variant = App\Models\Variant::all();

        $variant->each(function($variant){
            $variant->values()->saveMany(factory(App\Models\Value::class, mt_rand(2, 5))
                ->create(['variant_id' => $variant->id])
            );
        });
    }
}
