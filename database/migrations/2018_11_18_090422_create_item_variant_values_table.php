<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateItemVariantValuesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('item_variant_values', function (Blueprint $table) {
            $table->increments('id');
            $table->string('name', 255);

            $table->integer('item_variant_id')->unsigned();
            $table->foreign('item_variant_id')
                ->references('id')
                ->on('item_variants')
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
        Schema::dropIfExists('item_variant_values');
    }
}
