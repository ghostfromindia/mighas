<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;

class CreateProductVariantImagesTable extends Migration {

	/**
	 * Run the migrations.
	 *
	 * @return void
	 */
	public function up()
	{
		Schema::create('product_variant_images', function(Blueprint $table)
		{
			$table->increments('id');
			$table->integer('variant_id');
			$table->integer('image_id');
			$table->string('title', 250)->nullable();
			$table->string('alt', 250)->nullable();
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
		Schema::drop('product_variant_images');
	}

}
