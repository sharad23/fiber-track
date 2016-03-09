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

//Route::get('/', 'WelcomeController@index');
//Route::get('home', 'HomeController@index');
/*Route::controllers([
	'auth' => 'Auth\AuthController',
	'password' => 'Auth\PasswordController',
]);*/
//Route::resource('auth','Autheticate',['only' => ['index']]);
Route::get('testis',function(){

    /*$data =  \App\Model\FiberConnection::with('cores')
                                        ->where('id','99')
                                        ->get()
                                        ->toArray();

    echo '<pre>';
    print_r($data);
    echo '</pre>';*/

   /* \App\Model\ClientConnection::where('client_id','1')
                               ->where('order','>','1')
                               ->increment('order');*/
    
    /*echo '<pre>';
    print_r(Event::fire(new App\Events\AddEnd('sharad')));
    echo '</pre>';*/
    $data = new \App\Model\Location();
    
  

    $data = \App\Model\Location::whereIn('id',[$data->id])
                        ->get();
    
     echo '<pre>';
     print_r($data);
     echo '</pre>';
});
Route::get('/',function(){
   
       return View::make('home');
});
Route::post('auth','Autheticate@index');
Route::group(['prefix' => 'api','middleware' => ['token']], function()
{
        Route::resource('fiber','Fiber');
        Route::resource('fiber-connection','FiberConnection');
        Route::resource('fiber-connection-core','ConnectionCore');
        Route::resource('color','Color');
        Route::resource('end','End');
        Route::resource('location','Location');
        Route::resource('client','Client');
        Route::resource('client-connection','ClientConnection');
        Route::resource('user','User');
        Route::post('fiber-break/{id}','FiberConnection@fiberbreak');

});