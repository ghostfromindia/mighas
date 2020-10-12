<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;

class CreateBansTable extends Migration {

	/**
	 * Run the migrations.
	 *
	 * @return void
	 */
	public function up()
	{
		Schema::create('bans', function(Blueprint $table)
		{
			$table->integer('id')->unsigned();
			$table->string('bannable_type', 191);
			$table->bigInteger('bannable_id')->unsigned();
			$table->string('created_by_type', 191)->nullable();
			$table->bigInteger('created_by_id')->unsigned()->nullable();
			$table->text('comment', 65535)->nullable();
			$table->dateTime('expired_at')->nullable();
			$table->softDeletes();
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
		Schema::drop('bans');
	}

}
