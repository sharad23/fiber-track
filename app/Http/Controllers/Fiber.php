<?php namespace App\Http\Controllers;

use App\Http\Requests\CreateFiberFormRequest;
use App\Http\Controllers\Controller;

use Illuminate\Http\Request;

class Fiber extends Controller {

	/**
	 * Display a listing of the resource.
	 *
	 * @return Response
	 */
	public function index()
	{
		$fibers = \App\Model\Fiber::with('cores')
		                          ->with('user')
		                          ->get()
		                          ->toJson();

	    return response()->json($fibers);

         
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
	public function store(CreateFiberFormRequest $request)
	{   
		
		$fiber = new \App\Model\Fiber($request->only('name','brand','avilable_length','total_length','cores'));
		$fiber->user_id =  \Auth::user()->id;
		$fiber->save();

		//store colors
		$fiberCores = [];
        foreach($request->input('fiber_cores') as $key => $row){
              
               $fiberCores[] = new \App\Model\FiberCore(['color_id' => $row]);
		} 
		$cores = $fiber->cores()->saveMany($fiberCores);
		$fiber['cores'] = $cores;
        return response()->json($fiber); 
        
  
   }

	/**
	 * Display the specified resource.
	 *
	 * @param  int  $id
	 * @return Response
	 */
	public function show($id)
	{
		$fiber =  \App\Model\Fiber::with('cores')
		                          ->with('user')
		                          ->with('connections')
		                          ->get()
		                          ->toJson();

		return response()->json($fiber);                        
	}

	/**
	 * Show the form for editing the specified resource.
	 *
	 * @param  int  $id
	 * @return Response
	 */
	public function edit($id)
	{
		
	}

	/**
	 * Update the specified resource in storage.
	 *
	 * @param  int  $id
	 * @return Response
	 */
	public function update(CreateFiberFormRequest $request,$id)
	{
	    $result =  \App\Model\Fiber::where('id',$id)->update($request->only('name','brand','avilable_length','total_length','cores'));
        $fiberCores_ids = [];
        foreach($request->input('fiber_cores') as $key => $row){
              
               $core = \App\Model\FiberCore::find($request->input('fiber_cores_id')[$key]) ?: new \App\Model\FiberCore();
        	   $core->color_id = $row;
        	   $core->fiber_id = $id;
        	   $core->save();
               $fiberCores_ids[] = $core->id; 
		}
		\App\Model\FiberCore::where('fiber_id', $id)->whereNotIn('id', $fiberCores_ids)->delete(); 
	    
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
		$result =  \App\Model\Fiber::destroy($id);
		if($result)
	    	    return response()->json(['message'=>'Deleted'],200);
	    else
	            return response()->json(['message'=>'Not Found'],404);
	}

}
