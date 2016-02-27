<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateClientConnectionTable extends Migration {

	/**
	 * Run the migrations.
	 *
	 * @return void
	 */
	public function up()
	{
		Schema::create('client_connections', function(Blueprint $table)
		{
			$table->increments('id');
			$table->string('order');
			$table->string('connection_core_id1');
			$table->string('connection_core_id2');
			$table->string('client_id');
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
		Schema::drop('client_connections');
	}

}
