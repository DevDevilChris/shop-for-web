<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateOrderListTable extends Migration {

	/**
	 * Run the migrations.
	 *
	 * @return void
	 */
	public function up()
	{
		Schema::create('order_list', function(Blueprint $table)
		{
			$table->increments('id');
            $table->unsignedInteger('order_id');
            $table->unsignedInteger('product_id');
            $table->integer('product_qty');
            $table->double('product_price');
            $table->integer('product_vat');
			$table->timestamps();
            $table->foreign('order_id')->references('id')->on('order');
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
		Schema::drop('order_list', function($table) {
            $table->dropForeign('order_list_order_id_foreign');
            $table->dropForeign('order_list_product_id_foreign');
        });
	}

}
