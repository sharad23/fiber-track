<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class UpdateEndsTable extends Migration {

	/**
	 * Run the migrations.
	 *
	 * @return void
	 */
	public function up()
	{
		Schema::table('ends', function(Blueprint $table)
		{
			    $table->string('longitude');
			    $table->string('lattitude');
		});
	}

	/**
	 * Reverse the migrations.
	 *
	 * @return void
	 */
	public function down()
	{
		 Schema::table('ends', function(Blueprint $table)
			{
				    $table->dropColumn('longitude');
				    $table->dropColumn('lattitude');
			});
	}

}
