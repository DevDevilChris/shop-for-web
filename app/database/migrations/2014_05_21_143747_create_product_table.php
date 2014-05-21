<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateProductTable extends Migration {

	/**
	 * Run the migrations.
	 *
	 * @return void
	 */
	public function up()
	{
		Schema::create('product', function(Blueprint $table)
		{
			$table->increments('id');
            $table->unsignedInteger('category_id');
            $table->string('sku', 100);
            $table->string('name', 200);
            $table->text('description');
			$table->timestamps();
            $table->foreign('category_id')->references('id')->on('product_category');
		});
	}

	/**
	 * Reverse the migrations.
	 *
	 * @return void
	 */
	public function down()
	{
		Schema::drop('product', function($table) {
            $table->dropForeign('product_category_id_foreign');
        });
	}

}
