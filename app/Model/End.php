<?php namespace App\Model;

use Illuminate\Database\Eloquent\Model;

class End extends Model {

	protected $table = 'ends';
	
	public function location(){
         
          return $this->belongsTo('App\Model\Location','location_id','id');
	}
	public function user(){

          return $this->belongsTo('App\Model\User','user_id','id');
	}

}
