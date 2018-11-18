<?php

use Illuminate\Database\Seeder;

class VariantsTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        factory(\App\Models\Variant::class, 5)->create();
    }
}
