<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;

class CreateSettingTable extends Migration
{

    public function up()
    {
        Schema::create('setting', function (Blueprint $table) {
            $table->increments('id');
            $table->timestamps();
            $table->string('name');
            $table->string('email');
            $table->string('phone');
            $table->string('facebook');
            $table->string('twiter');
            $table->string('instegram');
            $table->string('about');
            $table->string('delivery_value');
        });
    }

    public function down()
    {
        Schema::drop('setting');
    }
}
