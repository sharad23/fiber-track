<?php namespace App\Model;

use Illuminate\Database\Eloquent\Model;

class FiberConnection extends Model {

    protected $table = 'fiber_connections';
	
	protected $fillable = ['end1','end2','user_id','fiber_id'];
	
	public function fiber(){

		   return $this->belongsTo('App\Model\Fiber','fiber_id','id');
	}

	public function user(){

		   return $this->belongsTo('App\Model\User','user_id','id');
	}

	public function end1(){
           
           return $this->belongsTo('App\Model\End','end1','id');
	} 
	public function end2(){
           
           return $this->belongsTo('App\Model\End','end2','id');
	}
    public function cores(){

    	   return $this->hasMany('App\Model\FiberConnectionCore','connection_id','id');
    }


}
