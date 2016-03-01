<?php namespace App\Model;

use Illuminate\Database\Eloquent\Model;

class Client extends Model {

	protected $table = 'clients';
	
	protected $fillable = ['name','user_id','location_id','service_type','longitude','lattitude'];

	public function connections(){

		return $this->hasMany('App\Model\ClientConnection','client_id','id'); 
	}

	public function user(){

		return $this->belongsTo('App\Model\User','user_id','id');
	}

	public function location(){

		return $this->belongsTo('App\Model\Location','location_id','id'); 
	}

	public function pod(){

		return $this->belongsTo('App\Model\Pod','pod_id','id');
	}



}
