<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;

class CreateAdminPagesTable extends Migration {

	/**
	 * Run the migrations.
	 *
	 * @return void
	 */
	public function up()
	{
		Schema::create('admin_pages', function(Blueprint $table)
		{
			$table->integer('id');
			$table->string('title', 250);
			$table->string('slug', 250);
			$table->string('permission', 250);
			$table->string('target', 10)->nullable();
			$table->string('icon', 50);
			$table->integer('parent')->default(0);
			$table->bigInteger('created_by');
			$table->bigInteger('updated_by');
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
		Schema::drop('admin_pages');
	}

}
