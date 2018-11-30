<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateVouchersTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('vouchers', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->string('code')->nullable();
            $table->string('name', 255);
            $table->string('image', 255)->nullable();
            $table->text('description')->nullable();
            // The number of uses currently
            $table->integer('uses')->unsigned()->nullable();
            // The max uses this voucher has
            $table->integer('max_uses')->unsigned()->nullable();
            // How many times a user can use this voucher.
            $table->integer('max_uses_user')->unsigned()->nullable();
            // The type can be: voucher, discount, sale. What ever you want.
            $table->tinyInteger('type')->unsigned();
            // The amount to discount by (in pennies) in this example.
            $table->integer('discount_amount');
            // Whether or not the voucher is a percentage or a fixed price.
            $table->boolean('is_fixed')->default(true);
            $table->timestamp('starts_at')->nullable();
            $table->timestamp('expires_at')->nullable();
            $table->timestamps();
            //$table->softDeletes();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('vouchers');
    }
}
