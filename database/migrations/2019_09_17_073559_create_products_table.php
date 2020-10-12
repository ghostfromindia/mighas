<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;

class CreateProductsTable extends Migration {

	/**
	 * Run the migrations.
	 *
	 * @return void
	 */
	public function up()
	{
		Schema::create('products', function(Blueprint $table)
		{
			$table->increments('id');
			$table->integer('category_id');
			$table->string('product_name', 250);
			$table->string('slug', 250);
			$table->string('tagline', 250)->nullable();
			$table->integer('brand_id')->nullable();
			$table->integer('vendor_id')->nullable();
			$table->text('summary', 65535);
			$table->text('top_description', 65535)->nullable();
			$table->text('bottom_description', 65535)->nullable();
			$table->integer('quantity')->nullable();
			$table->float('mrp', 10)->nullable();
			$table->float('sale_price', 10)->nullable();
			$table->boolean('is_featured_in_home_page')->default(0);
			$table->boolean('is_featured_in_category')->default(0);
			$table->boolean('is_new')->default(0);
			$table->boolean('is_top_seller')->default(0);
			$table->boolean('is_today_deal')->default(0);
			$table->boolean('is_active')->default(0);
			$table->boolean('is_completed')->default(0);
			$table->integer('default_image_id')->nullable();
			$table->string('page_heading', 250);
			$table->string('browser_title', 250)->nullable();
			$table->text('meta_keywords', 65535)->nullable();
			$table->text('meta_description', 65535)->nullable();
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
		Schema::drop('products');
	}

}
