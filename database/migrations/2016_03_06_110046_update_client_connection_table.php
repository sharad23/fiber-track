<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class UpdateClientConnectionTable extends Migration {

	/**
	 * Run the migrations.
	 *
	 * @return void
	 */
	public function up()
	{
	    Schema::table('client_connections', function(Blueprint $table)
		{
			 $table->string('connection_id');
			   
		});
	}

	/**
	 * Reverse the migrations.
	 *
	 * @return void
	 */
	public function down()
	{
		  Schema::table('client_connections', function(Blueprint $table)
		{
			 $table->dropColumn('connection_id');
			   
		});
	}

}
