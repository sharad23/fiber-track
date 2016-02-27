<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateConnectionTable extends Migration {

	/**
	 * Run the migrations.
	 *
	 * @return void
	 */
	public function up()
	{
		//
		Schema::create('fiber_connections', function(Blueprint $table)
		{
			$table->increments('id');
			$table->string('end1');
			$table->string('end2');
			$table->string('fiber_id');
			$table->string('user_id');
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
		Schema::drop('fiber_connections');
		 
	}

}
