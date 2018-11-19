<?php

use Illuminate\Database\Seeder;

class ItemPropertiesTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        factory(\App\Models\ItemProperty::class, 30)->create();
    }
}
