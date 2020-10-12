<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;

class CreateMediaLibraryTable extends Migration {

	/**
	 * Run the migrations.
	 *
	 * @return void
	 */
	public function up()
	{
		Schema::create('media_library', function(Blueprint $table)
		{
			$table->integer('id');
			$table->text('file_name', 65535);
			$table->string('file_path', 250);
			$table->string('thumb_file_path', 250);
			$table->string('file_type', 100);
			$table->string('file_size', 100);
			$table->string('dimensions', 50)->nullable();
			$table->string('media_type', 120)->default('Image');
			$table->string('title', 250)->nullable();
			$table->text('description', 16777215)->nullable();
			$table->string('alt_text', 250)->nullable();
			$table->string('related_type', 20)->nullable();
			$table->integer('related_id')->nullable();
			$table->bigInteger('created_by');
			$table->bigInteger('updated_by');
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
		Schema::drop('media_library');
	}

}
