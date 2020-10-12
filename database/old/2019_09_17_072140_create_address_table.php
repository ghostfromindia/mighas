<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;

class CreateAddressTable extends Migration {

	/**
	 * Run the migrations.
	 *
	 * @return void
	 */
	public function up()
	{
		Schema::create('address', function(Blueprint $table)
		{
			$table->integer('id');
			$table->string('name', 100);
			$table->integer('user_id');
			$table->string('mobile', 100);
			$table->integer('pincode');
			$table->string('state', 200);
			$table->string('city', 200);
			$table->text('address', 65535);
			$table->text('landmark', 65535)->nullable();
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
		Schema::drop('address');
	}

}
