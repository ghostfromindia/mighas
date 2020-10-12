<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;

class CreateBranchesTable extends Migration {

	/**
	 * Run the migrations.
	 *
	 * @return void
	 */
	public function up()
	{
		Schema::create('branches', function(Blueprint $table)
		{
			$table->bigInteger('id')->unsigned();
			$table->string('branch_name', 250);
			$table->string('browser_title', 250)->nullable();
			$table->string('address', 250)->nullable();
			$table->string('description', 500)->nullable();
			$table->string('email', 191)->nullable();
			$table->string('lattitude', 191)->nullable();
			$table->string('longitude', 100)->nullable();
			$table->string('slug', 100)->nullable();
			$table->string('website', 100)->nullable();
			$table->bigInteger('phone_code')->nullable();
			$table->bigInteger('phone')->nullable();
			$table->string('meta_description', 500)->nullable();
			$table->string('meta_keywords', 500)->nullable();
			$table->string('page_heading', 500)->nullable();
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
		Schema::drop('branches');
	}

}
