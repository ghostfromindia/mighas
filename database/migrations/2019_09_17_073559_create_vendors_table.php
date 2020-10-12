<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;

class CreateVendorsTable extends Migration {

	/**
	 * Run the migrations.
	 *
	 * @return void
	 */
	public function up()
	{
		Schema::create('vendors', function(Blueprint $table)
		{
			$table->integer('id', true);
			$table->string('vendor_name', 250);
			$table->string('page_heading', 250);
			$table->string('slug', 250);
			$table->string('contact_name', 250)->nullable();
			$table->integer('phone_code')->nullable();
			$table->bigInteger('phone')->nullable();
			$table->text('address', 65535)->nullable();
			$table->string('email', 250)->nullable();
			$table->text('description', 65535)->nullable();
			$table->string('browser_title', 250)->nullable();
			$table->text('meta_description', 65535)->nullable();
			$table->string('meta_keywords', 250)->nullable();
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
		Schema::drop('vendors');
	}

}
