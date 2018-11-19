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
        //factory(\App\Models\DeliveryMethod::class, 3)->create();

        App\Models\DeliveryMethod::create([
            'name' => 'Курьером - 300 рублей',
        ]);

        App\Models\DeliveryMethod::create([
            'name' => 'Самовывоз - бесплатно',
        ]);
    }
}
