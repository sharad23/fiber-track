<?php 

namespace App\Model;

use Illuminate\Database\Eloquent\Model;

class Fiber extends Model {

	//
	protected $table = 'fibers';
	
	protected $fillable = ['name','brand','available_length','total_length','cores','user_id'];
	
	public function cores(){

		 return $this->hasMany('App\Model\FiberCore','fiber_id','id');
	}

	public function user(){

		 return $this->belongsTo('App\Model\User','user_id','id');
	}

	public function connections(){

		 return $this->hasMany('App\Model\FiberConnection','fiber_id','id');
	}


}
