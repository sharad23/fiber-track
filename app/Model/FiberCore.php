<?php namespace App\Model;

use Illuminate\Database\Eloquent\Model;

class FiberCore extends Model {

	//
	protected $table = 'fiber_cores';
	
	protected $fillable = ['fiber_id','color_id'];
	
	public function fiber(){

		 return $this->belongsTo('App\Model\Fiber','fiber_id','id');
	}

	public function color(){

		 return $this->belongsTo('App\Model\Color','color_id','id');
	}

}
