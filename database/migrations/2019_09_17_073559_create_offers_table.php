<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;

class CreateOffersTable extends Migration {

	/**
	 * Run the migrations.
	 *
	 * @return void
	 */
	public function up()
	{
		Schema::create('offers', function(Blueprint $table)
		{
			$table->bigInteger('id', true)->unsigned();
			$table->string('offer_name', 250);
			$table->char('type', 10)->comment('Price, Combo, Free or group');
			$table->date('validity_start_date');
			$table->date('validity_end_date');
			$table->boolean('applicable_for_full_order')->default(0);
			$table->char('discount_type', 20)->nullable()->comment('Fixed Price, Discount Percentage, Discount Fixed');
			$table->float('amount', 10)->nullable();
			$table->integer('percentage')->nullable();
			$table->float('min_purchase_amount', 10)->nullable();
			$table->float('max_discount_amount', 10)->nullable();
			$table->boolean('is_active')->default(1);
			$table->string('browser_title', 250)->nullable();
			$table->string('meta_description', 250)->nullable();
			$table->string('meta_keywords', 520)->nullable();
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
		Schema::drop('offers');
	}

}
