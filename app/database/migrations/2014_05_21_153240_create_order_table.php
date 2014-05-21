<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateOrderTable extends Migration {

	/**
	 * Run the migrations.
	 *
	 * @return void
	 */
	public function up()
	{
		Schema::create('order', function(Blueprint $table)
		{
			$table->increments('id');
            $table->unsignedInteger('status_id');
            $table->unsignedInteger('user_id');
            $table->text('reference');
			$table->timestamps();
            $table->foreign('status_id')->references('id')->on('order_status');
            $table->foreign('user_id')->references('id')->on('users');
		});
	}

	/**
	 * Reverse the migrations.
	 *
	 * @return void
	 */
	public function down()
	{
		Schema::drop('order', function($table) {
            $table->dropForeign('order_status_id_foreign');
            $table->dropForeign('order_user_id_foreign');
        });
	}

}
