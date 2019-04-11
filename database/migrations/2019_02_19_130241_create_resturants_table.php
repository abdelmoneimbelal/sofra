<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;

class CreateResturantsTable extends Migration {

	public function up()
	{
		Schema::create('resturants', function(Blueprint $table) {
			$table->increments('id');
			$table->timestamps();
			$table->string('name');
			$table->integer('region_id')->unsigned();
			$table->string('password');
			$table->string('email');
			$table->enum('status', array('open', 'close'));
			$table->string('image');
			$table->string('less_order');
			$table->string('delivery_value');
			$table->string('phone');
			$table->string('whatsapp');
			$table->string('api_token')->nullable();
			$table->string('pin_code')->nullable();
		});
	}

	public function down()
	{
		Schema::drop('resturants');
	}
}