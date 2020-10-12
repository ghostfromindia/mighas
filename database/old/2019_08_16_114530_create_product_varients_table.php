<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateProductVarientsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('product_variants', function (Blueprint $table) {
            $table->increments('id');
            $table->integer('products_id');
            $table->integer('level1_attribute_value_id')->nullable();
            $table->integer('level2_attribute_value_id')->nullable();
            $table->integer('level3_attribute_value_id')->nullable();
            $table->boolean('is_default')->default(0);
            $table->string('sku', 50)->nullable();
            $table->double('retail_price', 10, 2)->nullable();
            $table->double('sale_price', 10, 2)->nullable();
            $table->double('landing_price', 10, 2)->nullable();
            $table->integer('quantity')->nullable();
            $table->text('short_description')->nullable();
            $table->integer('created_by');
            $table->integer('updated_by');
            $table->timestamps();
            $table->softDeletes();
        });

        Schema::create('product_varient_images', function (Blueprint $table) {
            $table->increments('id');
            $table->integer('varient_id');
            $table->integer('image_id');
            $table->boolean('is_common')->default(0);
            $table->timestamps();
            $table->softDeletes();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('product_variants');
        Schema::dropIfExists('product_variant_images');
    }
}
