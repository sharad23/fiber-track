<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateConnectionCoreTable extends Migration {

	/**
	 * Run the migrations.
	 *
	 * @return void
	 */
	public function up()
	{   
		//flag 0  means empty
        //flag 1 means client
        //flag 2 means splitter 1 
        //flag 3 means splitter 2
        //flag 4 means master
		Schema::create('connection_cores', function(Blueprint $table)
		{
				$table->increments('id');
				$table->string('connection_id');
				$table->string('color_id');
				$table->string('flag');
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
		Schema::drop('connection_cores');
	}

}
