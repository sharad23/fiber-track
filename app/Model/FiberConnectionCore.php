<?php namespace App\Model;

use Illuminate\Database\Eloquent\Model;

class FiberConnectionCore extends Model {

	protected $table = 'connection_cores';
	protected $fillable = ['connection_id','color_id','flag'];

	public function color(){

		  return $this->belongsTo('App\Model\Color');
	}
}
