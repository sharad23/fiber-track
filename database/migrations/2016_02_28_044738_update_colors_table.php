<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class UpdateColorsTable extends Migration {

	/**
	 * Run the migrations.
	 *
	 * @return void
	 */
	public function up()
	{
		Schema::table('colors', function(Blueprint $table)
		{
			    $table->string('user_id');
			   
		});
	}

	/**
	 * Reverse the migrations.
	 *
	 * @return void
	 */
	public function down()
	{
		Schema::table('colors', function(Blueprint $table)
		{
			    $table->dropColumn('user_id');
			    
		});
	}

}
