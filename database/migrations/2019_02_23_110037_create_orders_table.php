<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;

class CreateOrdersTable extends Migration {

	public function up()
	{
		Schema::create('orders', function(Blueprint $table) {
			$table->increments('id');
			$table->timestamps();
			$table->string('title');
			$table->string('description');
			$table->enum('rate', array('1', '2', '3', '4', '5'));
			$table->tinyInteger('status')->default('1');
			$table->string('less_order');
			$table->string('delivery_value');
			$table->integer('resturant_id');
			$table->integer('city_id')->unsigned();
			$table->integer('client_id')->unsigned();
			$table->integer('payment_method_id')->unsigned();
			$table->integer('notification_id')->unsigned();
		});
	}

	public function down()
	{
		Schema::drop('orders');
	}
}