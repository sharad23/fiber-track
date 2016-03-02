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
		return $next($request);

    }

}
