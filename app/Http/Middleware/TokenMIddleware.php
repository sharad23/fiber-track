<?php namespace App\Http\Middleware;

use Closure;
use \Firebase\JWT\JWT;

class TokenMIddleware {

	/**
	 * Handle an incoming request.
	 *
	 * @param  \Illuminate\Http\Request  $request
	 * @param  \Closure  $next
	 * @return mixed
	 */
	public function handle($request, Closure $next)
	{
		$token = $request->header('x-access-token');
	    $decoded = JWT::decode($token,\Config::get('jwt-key.jwt-key'), array('HS256'));
	    //$request->attributes->add(['myAttribute' => 'myValue']);
        if(\Auth::attempt(array('username'=>$decoded->username,'password'=>$decoded->password))){
             
               return $next($request);
              
        }
        else{

        	  return response()->json(['error' => 'invalid_credentias'], 401);
        }


	    

    }

}
