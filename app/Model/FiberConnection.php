<?php namespace App\Model;

use Illuminate\Database\Eloquent\Model;

class FiberConnection extends Model {

    protected $table = 'fiber_connections';
	
	protected $fillable = ['end1','end2','user_id','fiber_id'];
	
	

}
