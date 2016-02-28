<?php namespace App\Model;

use Illuminate\Database\Eloquent\Model;

class End extends Model {

	protected $table = 'ends';
	
	protected $fillable = ['name','location_id','longitude','lattitude','user_id'];
	
	public function location(){
         
          return $this->belongsTo('App\Model\Location','location_id','id');
	} 

	public function user(){
          
          return $this->belongsTo('App\Model\User','user_id','id');
	}

	public function end1_connections(){
          
          return $this->hasMany('App\Model\FiberConnection','end1','id');
	}

	public function end2_connections(){
           
          return $this->hasMany('App\Model\FiberConnection','end2','id');
	}
	
}
