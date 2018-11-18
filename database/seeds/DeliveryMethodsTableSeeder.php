<?php

use Illuminate\Database\Seeder;

class DeliveryMethodsTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        factory(\App\Models\DeliveryMethod::class, 3)->create();
    }
}
