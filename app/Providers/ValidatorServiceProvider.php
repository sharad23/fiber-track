<?php namespace App\Providers;

use Illuminate\Support\ServiceProvider;
use Validator;
class ValidatorServiceProvider extends ServiceProvider {

	/**
	 * Bootstrap the application services.
	 *
	 * @return void
	 */
	public function boot()
	{
		Validator::extend('sharad', function($attribute, $value, $parameters) {
            

            if($parameters[0] == 0){
            	 return true;
            }
            else{

                if($value == 0){
                	 return false;
                }
                else{

                	 return true;
                }
            } 
          

               
        
	    });
	     
	}

	/**
	 * Register the application services.
	 *
	 * @return void
	 */
	public function register()
	{
		//
	}

}
