<?php

use Illuminate\Database\Seeder;

class ShopInformationTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        factory(App\Models\ShopInformation::class, 1)->create();
    }
}
