<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateCatalogsShopInformationPivot extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('catalog_shop_information', function (Blueprint $table) {
            $table->increments('id');

            $table->unsignedInteger('catalog_id');
            $table->foreign('catalog_id')
                ->references('id')
                ->on('catalogs')
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
        Schema::dropIfExists('catalog_shop_information');
    }
}
