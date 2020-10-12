<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;

class CreatePagesTable extends Migration {

	/**
	 * Run the migrations.
	 *
	 * @return void
	 */
	public function up()
	{
		Schema::create('pages', function(Blueprint $table)
		{
			$table->integer('id');
			$table->string('code', 250);
			$table->string('title', 250);
			$table->text('description', 16777215)->nullable();
			$table->string('browser_title', 250)->nullable();
			$table->text('meta_description', 65535)->nullable();
			$table->text('meta_keywords', 65535)->nullable();
			$table->integer('media_id')->nullable();
			$table->integer('video_id')->nullable();
			$table->integer('youtube_id')->nullable();
			$table->boolean('status')->nullable()->default(1);
			$table->boolean('apply_button_top')->default(0);
			$table->boolean('apply_button_bottom')->default(0);
			$table->integer('parent_id')->default(0);
			$table->integer('created_by');
			$table->integer('updated_by');
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
		Schema::drop('pages');
	}

}
