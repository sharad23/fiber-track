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
             
              return $this->setToken();
              
         }
         elseif(\Auth::attempt(array('username'=>$request->input('email'),'password'=>$request->input('password')))){
             
              return $this->setToken();
         }  
         else{
             
              return response()->json(['error' => 'invalid_credentias'], 401);
         }

        /*$key = "example_key";
		$token = array(
		    "iss" => "http://example.org",
		    "aud" => "http://example.com",
		    "iat" => 1356999524,
		    "nbf" => 1357000000
		);
        
        $jwt = JWT::encode($token, $key);

        $decoded = JWT::decode($jwt, $key, array('HS256'));
        echo '<pre>';
        print_r($decoded);
        echo '</pre>';*/
       

     }

     private function setToken(){
     
          $token = \Auth::user();
          $jwt = JWT::encode($token,\Config::get('jwt-key.jwt-key'));
          return response()->json([ 'token' => $jwt],200);
     }

	

}
