<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;

class CreateMenuItemsTable extends Migration {

	/**
	 * Run the migrations.
	 *
	 * @return void
	 */
	public function up()
	{
		Schema::create('menu_items', function(Blueprint $table)
		{
			$table->integer('id')->unsigned();
			$table->string('label', 191);
			$table->string('link', 191);
			$table->integer('parent')->unsigned()->default(0);
			$table->integer('sort')->default(0);
			$table->string('class', 191)->nullable();
			$table->integer('menu')->unsigned();
			$table->integer('depth')->default(0);
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
		Schema::drop('menu_items');
	}

}
