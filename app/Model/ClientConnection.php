<?php namespace App\Model;

use Illuminate\Database\Eloquent\Model;

class ClientConnection extends Model {

	protected $table = 'client_connections';
	
	protected $fillable = ['order','client_id','connection_core_id1','connection_core_id2','connection_id'];

	public function client(){

		  return $this->belongsTo('App\Model\Client','client_id','id');
	}

	public function connection_core_1(){
          
          return $this->belongsTo('App\Model\FiberConnectionCore','connection_core_id1','id');
	}

	public function connection_core_2(){
          
          return $this->belongsTo('App\Model\FiberConnectionCore','connection_core_id2','id');
	}

}
