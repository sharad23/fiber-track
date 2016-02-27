<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateFiberTable extends Migration {

	/**
	 * Run the migrations.
	 *
	 * @return void
	 */
	public function up()
	{
		//
		Schema::create('fibers', function(Blueprint $table)
		{
			$table->increments('id');
			$table->string('name');
			$table->string('brand');
			$table->string('total_length');
			$table->string('avilable_length');
			$table->string('cores');
			$table->timestamps();
		});
	}

	/**
	 * Reverse the migrations.
	 *
	 * @return void
	 */
	public function down()
	{
		//
		Schema::drop('fibers');
	}

}
