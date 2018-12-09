<?php

use Illuminate\Database\Seeder;

class OrdersTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $users = factory(App\Models\User::class, 5)->create();



     /*   $users->each(function($user) {
           $user->orders()->saveMany(factory(App\Models\Order::class, 2)->create([
               'user_id' => $user->id
           ])) ;
        });*/

        $users->each(function($user){
            $user->cart()->save(App\Models\Cart::create([
                'user_id' => $user->id
            ]));
        });
    }
}
