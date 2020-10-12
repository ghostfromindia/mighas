<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;

class CreateProductCateoryAttributesTable extends Migration {

	/**
	 * Run the migrations.
	 *
	 * @return void
	 */
	public function up()
	{
		Schema::create('product_cateory_attributes', function(Blueprint $table)
		{
			$table->integer('id')->unsigned();
			$table->integer('category_id');
			$table->string('attribute_name', 191);
			$table->string('attribute_type', 20);
			$table->integer('group_id')->nullable();
			$table->boolean('show_as_variant')->default(0);
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
		Schema::drop('product_cateory_attributes');
	}

}
