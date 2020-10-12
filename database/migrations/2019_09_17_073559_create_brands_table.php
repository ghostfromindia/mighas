<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;

class CreateBrandsTable extends Migration {

	/**
	 * Run the migrations.
	 *
	 * @return void
	 */
	public function up()
	{
		Schema::create('brands', function(Blueprint $table)
		{
			$table->bigInteger('id')->unsigned();
			$table->string('brand_name', 250);
			$table->string('browser_title', 250)->nullable();
			$table->string('meta_description', 250)->nullable();
			$table->string('meta_keywords', 520)->nullable();
			$table->string('page_heading', 250)->nullable();
			$table->string('slug', 250);
			$table->integer('created_by')->nullable();
			$table->integer('updated_by')->nullable();
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
		Schema::drop('brands');
	}

}
