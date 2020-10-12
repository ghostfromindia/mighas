<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;

class CreateCategoriesTable extends Migration {

	/**
	 * Run the migrations.
	 *
	 * @return void
	 */
	public function up()
	{
		Schema::create('categories', function(Blueprint $table)
		{
			$table->integer('id');
			$table->integer('parent_category_id')->nullable();
			$table->string('category_name', 200);
			$table->string('slug', 200);
			$table->text('top_description')->nullable();
			$table->text('bottom_description')->nullable();
			$table->text('page_title')->nullable();
			$table->string('browser_title', 500)->nullable();
			$table->string('meta_keywords', 500)->nullable();
			$table->text('meta_description', 65535)->nullable();
			$table->text('tagline', 65535)->nullable();
			$table->integer('banner_image')->nullable();
			$table->integer('thumbnail_image')->nullable();
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
		Schema::drop('categories');
	}

}
