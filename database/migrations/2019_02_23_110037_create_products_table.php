<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;

class CreateProductsTable extends Migration {

	public function up()
	{
		Schema::create('products', function(Blueprint $table) {
			$table->increments('id');
			$table->timestamps();
			$table->string('name');
			$table->string('description');
			$table->decimal('price');
			$table->string('image');
			$table->string('processing_time');
			
			$table->integer('resturant_id')->unsigned();
			$table->integer('item_id')->unsigned();
		});
	}

	public function down()
	{
		Schema::drop('products');
	}
}