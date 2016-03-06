<?php namespace App\Http\Controllers;

use App\Http\Requests;
use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

class FiberConnection extends Controller {

	/**
	 * Display a listing of the resource.
	 *
	 * @return Response
	 */
	public function index()
	{
		$conn = \App\Model\FiberConnection::with('end1')
		                                  ->with('end2')
		                                  ->with('user')
		                                  ->with('fiber')
		                                  ->get();

		return response()->json($conn);
	}

	/**
	 * Show the form for creating a new resource.
	 *
	 * @return Response
	 */
	public function create()
	{
		//
	}

	/**
	 * Store a newly created resource in storage.
	 *
	 * @return Response
	 */
	public function store(Request $request)
	{    
         $input = $request->only('end1','end2','fiber_id');
         $input['user_id'] =  \Auth::user()->id;
         $conn =  \App\Model\FiberConnection::create($input);
         return response()->json($conn);
    }

	/**
	 * Display the specified resource.
	 *
	 * @param  int  $id
	 * @return Response
	 */
	public function show($id)
	{
		$conn = \App\Model\FiberConnection::with('end1')
	                                  ->with('end2')
	                                  ->with('user')
	                                  ->with('fiber')
	                                  ->with('cores')
	                                  ->get();

	    return response()->json($conn);
	}

	/**
	 * Show the form for editing the specified resource.
	 *
	 * @param  int  $id
	 * @return Response
	 */
	

	/**
	 * Update the specified resource in storage.
	 *
	 * @param  int  $id
	 * @return Response
	 */
	public function update(Request $request,$id)
	{     
		 
		$result = \App\Model\FiberConnectionCore::where('connection_id',$id)
                                        ->where('flag','!=','0')
                                        ->count();
        if($result)
            
             return response()->json(['message'=>'Cannot update as the fiber connection is already occupied by the user'],400);
        
        else
	         \App\Model\FiberConnectionCore::where('connection_id',$id)
	                                      ->delete();
			 $conn =  \App\Model\FiberConnection::find($id);
			 $conn->fiber_id = $request->input('fiber_id');
			 $conn->end1 = $request->input('end1');
			 $conn->end2 = $request->input('end2');
			 $result = $conn->save();
			 $fiberCores = \App\Model\FiberCore::where('fiber_id',$conn->fiber_id)
	                                           ->get();

	         foreach($fiberCores as $core){

	         	   $connection_cores[] = new \App\Model\FiberConnectionCore(array('flag'=> 0,'color_id' => $core->color_id ));
	         }
	         
	         $cores = $conn->cores()->saveMany($connection_cores);
			 if($result)
		    	    return response()->json(['message'=>'Updated'],200);
		     else
		            return response()->json(['message'=>'Not Found'],404);
	

		
    }

	/**
	 * Remove the specified resource from storage.
	 *
	 * @param  int  $id
	 * @return Response
	 */
	public function destroy($id)
	{
		$result = \App\Model\FiberConnection::destroy($id);
		if($result)
	    	return response()->json(['message'=>'Deleted'],200);
	    else
	        return response()->json(['message'=>'Id Not Found'],404);  

	}

	public function fiberbreak($id, Request $request){
          
          
		   if(!$request->input('new_end_id')){
             
                 $newend = new \App\Model\End(array('name'=> $request->input('new_end'),'location_id'=>$request->input('new_end_location_id'),'user_id'=>\Auth::user()->id));
		         $newend->save();
                 $newend_id = $newend->id;
		   }
		   else{

		   	     $newend_id = $request->input('new_end_id');
		   }

		   $conn = \App\Model\FiberConnection::with('cores')
		                                      ->where('id',$id)
		                                      ->first();
		   //create a new fiber conn
		   $input =  array('end1'=>$newend_id,'end2'=>$conn->end2,'fiber_id'=>$request->input('fiber_id'),'user_id'=>\Auth::user()->id);
		   $newconn = \App\Model\FiberConnection::create($input);
           //updating a existing fiber conn
           $conn->end2 = $newend_id;
		   $conn->save();
           $cores = $conn->cores->toArray();
		   foreach($cores as $core){

		   	    if($core['flag'] == 0){

		   	    }
		   	    elseif($core['flag'] == 1){

		   	    	 $client_conn = \App\Model\ClientConnection::where('connection_core_id1',$core['id'])
		   	    	                            ->orWhere('connection_core_id2',$core['id'])
		   	    	                            ->first();
		   	    	 if($client_conn){
                          
                          \App\Model\ClientConnection::where('client_id',$client_conn->client_id)
                                                     ->where('order','>',$client_conn->order)
                                                     ->increment('order');
                          $new_client_conn_order = $client_conn->client_id + 1;
                          $new_client_conn = \App\Model\ClientConnection::create(array('client_id'=>$client_conn->client_id,'order'=>$new_client_conn_order,'connection_id'=>$newconn->id ));
		   	    	      return response()->json(['message'=>'Fiber Breaked'],200); 
		   	    	 }
                }
		   	    elseif($core['flag'] == 2){
                      

		   	    }
		   }
         

           
         



    }
    


}
