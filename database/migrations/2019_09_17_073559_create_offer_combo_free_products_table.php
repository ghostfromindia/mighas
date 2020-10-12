<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;

class CreateOfferComboFreeProductsTable extends Migration {

	/**
	 * Run the migrations.
	 *
	 * @return void
	 */
	public function up()
	{
		Schema::create('offer_combo_free_products', function(Blueprint $table)
		{
			$table->increments('id');
			$table->integer('products_id')->nullable();
			$table->integer('offers_id');
			$table->char('type', 20)->comment('Free, Fixed Price, Discount Percentage, Discount Fixed, Combo discount fixed, combo discount percentage');
			$table->float('fixed_price', 10)->nullable();
			$table->float('discount_amount', 10)->nullable();
			$table->integer('discount_percentage')->nullable();
			$table->float('max_discount_amount', 10)->nullable();
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
		Schema::drop('offer_combo_free_products');
	}

}
