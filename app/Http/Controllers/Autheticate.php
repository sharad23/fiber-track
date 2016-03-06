<?php namespace App\Http\Controllers;

use App\Http\Requests;
use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use \Firebase\JWT\JWT;


class Autheticate extends Controller {

	/**
	 * Display a listing of the resource.
	 *
	 * @return Response
	 */
	
	public function index(Request $request)
	{
		 
         if(\Auth::attempt(array('email'=>$request->input('email'),'password'=>$request->input('password')))){
             
              return $this->setToken($request->input('password'));
            
              
         }
         elseif(\Auth::attempt(array('username'=>$request->input('email'),'password'=>$request->input('password')))){
             
              return $this->setToken($request->input('password'));
         }  
         else{
             
              return response()->json(['error' => 'invalid_credentias'], 401);
         }


     }

     private function setToken($password){
     
          $token = \Auth::user()->toArray();
          $token['password'] = $password;
          $jwt = JWT::encode($token,\Config::get('jwt-key.jwt-key'));
          return response()->json([ 'token' => $jwt],200);
     }

	

}
