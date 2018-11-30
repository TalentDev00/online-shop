<?php

use App\Models\User;
use App\Models\Voucher;
use Illuminate\Database\Seeder;

class UsersVouchersTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $vouchers = Voucher::all();
        $users = User::all();

        $users->each(function($user) use ($vouchers){
            $user->vouchers()->sync($vouchers);
        });
    }
}
