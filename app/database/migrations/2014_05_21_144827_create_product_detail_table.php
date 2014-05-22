<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateProductDetailTable extends Migration {

	/**
	 * Run the migrations.
	 *
	 * @return void
	 */
	public function up()
	{
		Schema::create('product_detail', function(Blueprint $table)
		{
			$table->increments('detail_id');
            $table->unsignedInteger('product_id');
            $table->integer('vat');
            $table->integer('delivery_time');
            $table->double('price');
			$table->timestamps();
            $table->foreign('product_id')->references('id')->on('product');
		});
	}

	/**
	 * Reverse the migrations.
	 *
	 * @return void
	 */
	public function down()
	{
		Schema::drop('product_detail', function($table) {
            $table->dropForeign('product_detail_product_id_foreign');
        });
	}

}
