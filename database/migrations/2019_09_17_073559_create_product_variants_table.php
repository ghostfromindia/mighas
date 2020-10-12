<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;

class CreateProductVariantsTable extends Migration {

	/**
	 * Run the migrations.
	 *
	 * @return void
	 */
	public function up()
	{
		Schema::create('product_variants', function(Blueprint $table)
		{
			$table->increments('id');
			$table->integer('products_id');
			$table->string('name', 250);
			$table->string('slug', 250);
			$table->integer('level1_attribute_value_id')->nullable();
			$table->integer('level2_attribute_value_id')->nullable();
			$table->integer('level3_attribute_value_id')->nullable();
			$table->boolean('is_default')->default(0);
			$table->string('sku', 50)->nullable();
			$table->float('retail_price', 10)->nullable();
			$table->float('sale_price', 10)->nullable();
			$table->float('landing_price', 10)->nullable();
			$table->integer('quantity')->nullable();
			$table->text('short_description', 65535)->nullable();
			$table->integer('image_id')->nullable();
			$table->integer('created_by');
			$table->integer('updated_by');
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
		Schema::drop('product_variants');
	}

}
