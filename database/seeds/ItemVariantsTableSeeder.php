<?php

use Illuminate\Database\Seeder;

class ItemVariantsTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        factory(\App\Models\ItemVariant::class, 5)->create();
    }
}
