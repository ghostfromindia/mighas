<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateMenuItemsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('menu_items', function (Blueprint $table) {
            $table->increments('id');
            $table->integer('menu_id');
            $table->string('title', '250');
            $table->string('url', '250')->nullable();
            $table->integer('pages_id')->nullable();
            $table->string('menu_type', '50');
            $table->smallInteger('menu_order')->default(1);
            $table->integer('parent_id')->default(0);
            $table->boolean('target_blank')->default(0);
            $table->string('original_title', '250')->nullable();
            $table->string('menu_nextable_id', '250')->nullable();
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
        Schema::dropIfExists('menu_items');
    }
}
