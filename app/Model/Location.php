<?php namespace App\Model;

use Illuminate\Database\Eloquent\Model;

class Location extends Model {

	protected $table = 'locations';
	
	protected $fillable = ['name','user_id'];

	public function ends(){

		 return $this->hasMany('App\Model\End','location_id','id');
	}
}
