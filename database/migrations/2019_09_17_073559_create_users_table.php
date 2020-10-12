<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;

class CreateUsersTable extends Migration {

	/**
	 * Run the migrations.
	 *
	 * @return void
	 */
	public function up()
	{
		Schema::create('users', function(Blueprint $table)
		{
			$table->bigInteger('id', true)->unsigned();
			$table->string('username', 250)->nullable();
			$table->string('first_name', 250)->nullable();
			$table->string('last_name', 250)->nullable();
			$table->string('email', 191)->unique();
			$table->dateTime('email_verified_at')->nullable();
			$table->string('password', 191);
			$table->string('remember_token', 100)->nullable();
			$table->integer('country_code')->nullable();
			$table->bigInteger('phone_number')->nullable();
			$table->integer('country_id')->nullable();
			$table->integer('state_id')->nullable();
			$table->string('pin_code', 10)->nullable();
			$table->string('address', 500)->nullable();
			$table->dateTime('banned_at')->nullable();
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
		Schema::drop('users');
	}

}
