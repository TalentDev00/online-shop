<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateDeliveryMethodsShopInformationPivot extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('delivery_method_shop_information', function (Blueprint $table) {
            $table->increments('id');

            $table->unsignedInteger('delivery_method_id');
            $table->foreign('delivery_method_id')
                ->references('id')
                ->on('delivery_methods')
                ->onDelete('cascade')
                ->onUpdate('cascade');

            $table->unsignedInteger('shop_information_id');
            $table->foreign('shop_information_id')
                ->references('id')
                ->on('shop_information')
                ->onDelete('cascade')
                ->onUpdate('cascade');

            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('delivery_method_shop_information');
    }
}
