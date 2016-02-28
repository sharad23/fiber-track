<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class UpdateFibersTable extends Migration {

	/**
	 * Run the migrations.
	 *
	 * @return void
	 */
	public function up()
	{
		Schema::table('fibers', function(Blueprint $table)
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
		Schema::table('fibers', function(Blueprint $table)
		{
			    $table->dropColumn('user_id');
			    
		});
	}

}
