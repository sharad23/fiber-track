<?php namespace App\Model;

use Illuminate\Database\Eloquent\Model;

class FiberConnectionCore extends Model {

	protected $table = 'connection_cores';

	public function color(){

		  return $this->belongsTo('App\Model\Color');
	}
}
