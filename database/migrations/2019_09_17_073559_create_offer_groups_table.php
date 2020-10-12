<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;

class CreateOfferGroupsTable extends Migration {

	/**
	 * Run the migrations.
	 *
	 * @return void
	 */
	public function up()
	{
		Schema::create('offer_groups', function(Blueprint $table)
		{
			$table->integer('id')->unsigned();
			$table->integer('groups_id');
			$table->integer('offers_id');
			$table->integer('how_many_to_buy');
			$table->integer('how_many_to_get_free')->default(1);
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
		Schema::drop('offer_groups');
	}

}
