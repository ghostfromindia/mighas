<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateProductCategoryAttributesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('product_cateory_attributes', function (Blueprint $table) {
            $table->increments('id');
            $table->integer('category_id');
            $table->string('attribute_name');
            $table->string('attribute_slug');
            $table->boolean('show_as_variant')->default(0);
            $table->timestamps();
        });

        Schema::create('product_cateory_attribute_values', function (Blueprint $table) {
            $table->increments('id');
            $table->integer('attribute_id');
            $table->string('value');
            $table->string('value_slug');
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
        Schema::dropIfExists('product_cateory_attributes');
        Schema::dropIfExists('product_cateory_attribute_values');
    }
}
