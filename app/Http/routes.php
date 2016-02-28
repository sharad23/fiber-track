<?php

/*
|--------------------------------------------------------------------------
| Application Routes
|--------------------------------------------------------------------------
|
| Here is where you can register all of the routes for an application.
| It's a breeze. Simply tell Laravel the URIs it should respond to
| and give it the controller to call when that URI is requested.
|
*/
Route::get('users',function(){
        
        /*echo '<pre>';
        print_r(App\Model\Pod::all());
        echo '</pre>';*/
        /*echo '<pre>';
        print_r(App\Model\FiberCore::find(1)->fiber->toArray());
        echo '</pre>';

        echo '<pre>';
        print_r(App\Model\Fiber::find(1)->cores()->get()->toArray());
        echo '</pre>';
        */

        echo '<pre>';
        print_r(App\Model\Fiber::with(array('cores'=>function($query){
                                          
                                           $query->with('color');
                                     }))
                               ->with('user')
                               ->with('connections')
        	                   ->where('id',1)
        	                   ->get()
        	                   ->toArray());
        echo '</pre>';
});

Route::get('connect',function(){

       echo '<pre>';
       print_r(App\Model\FiberConnection::with('fiber')
                               ->with(array('end1'=>function($query){
                                        
                                         $query->with('location');
                                         $query->with('user');
                                 }))
                               ->with(array('end2'=>function($query){
                                         
                                         $query->with('location');
                                         $query->with('user');
                                }))
                               ->with('user')
                               ->with(array('cores'=>function($query){

                                        $query->with('color');
                                    }))
                               ->get()
                               ->toArray());
       echo '<pre>';
});

Route::get('basedOnLocation',function(){

      echo '<pre>';
      print_r(App\Model\Location::where('name','naxal')
                                ->get()
                                ->toArray());
      echo '</pre>';
});


Route::get('/', 'WelcomeController@index');

Route::get('home', 'HomeController@index');

Route::controllers([
	'auth' => 'Auth\AuthController',
	'password' => 'Auth\PasswordController',
]);
