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
/*Route::get('users',function(){
        
    

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
      print_r(App\Model\Location::with(array('ends'=>function($query){
                                           
                                         //get all connection
                                        $query->with(array('end1_connections'=>function($query){
                                              
                                               $query->with(array('cores'=>function($query){
                                                       
                                                       //$query->where('flag',0);
  
                                               }));
                                        }));

                                         $query->with(array('end2_connections'=>function($query){
                                              
                                               $query->with(array('cores'=>function($query){
                                                       
                                                       //$query->where('flag',0);
  
                                               }));
                                        }));
                                 }))
                                ->where('name','naxal')
                                ->get()
                                ->toArray());
      echo '</pre>';
});

Route::get('pod',function(){
         
          echo '<pre>';
          print_r(App\Model\Pod::all()->toArray());
          echo '</pre>';
});

Route::get('client',function(){

      echo '<pre>';
      print_r(App\Model\Client::with(array('connections'=>function($query){
                              
                               $query->with(array('connection_core_id1' => function($query){
                                       
                                        $query->with('color');
                               }));
                                $query->with(array('connection_core_id2' => function($query){
                                       
                                        $query->with('color');
                               }));
                    }))
                   ->with('location')
                   ->with('user')
                   ->with('pod')
                   ->get()
                   ->toArray());
       
     
      echo '</pre>';
});
//get free connections
Route::get('free',function(){
      
      echo '<pre>';
      print_r(App\Model\Location::with(array('ends'=>function($query){
                                           
                                         //get all connection
                                        $query->with(array('end1_connections'=>function($query){
                                              
                                               $query->with(array('cores'=>function($query){
                                                       
                                                       $query->where('flag',0);
  
                                               }));
                                        }));

                                         $query->with(array('end2_connections'=>function($query){
                                              
                                               $query->with(array('cores'=>function($query){
                                                       
                                                       $query->where('flag',0);
  
                                               }));
                                        }));
                                 }))
                                ->where('name','naxal')
                                ->get()
                                ->toArray());
      echo '</pre>';
});
*/

Route::get('/', 'WelcomeController@index');
Route::get('home', 'HomeController@index');
Route::resource('fiber','Fiber');
Route::controllers([
	'auth' => 'Auth\AuthController',
	'password' => 'Auth\PasswordController',
]);
