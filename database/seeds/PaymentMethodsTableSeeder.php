<?php

use Illuminate\Database\Seeder;

class PaymentMethodsTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        App\Models\PaymentMethod::create([
            'name' => 'Наличными',
        ]);

        App\Models\PaymentMethod::create([
            'name' => 'Картой',
        ]);
    }
}
