<?php namespace App\Http\Controllers;

use App\Http\Requests\CreateEndFormRequest;
use App\Http\Controllers\Controller;

use Illuminate\Http\Request;

class End extends Controller {

	/**
	 * Display a listing of the resource.
	 *
	 * @return Response
	 */
	public function index()
	{   
		$ends = \App\Model\End::with('location')
	                          ->with('user')
	                          ->get()
	                          ->toArray();

	    return response()->json($ends);

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
	public function store(CreateEndFormRequest $request)
	{
	    $end = new \App\Model\End($request->only('name','location_id','longitude','lattitude'));
		$end->user_id =  \Auth::user()->id;
		$end->save(); 
		return response()->json($end); 
	}

	/**
	 * Display the specified resource.
	 *
	 * @param  int  $id
	 * @return Response
	 */
	public function show($id)
	{
		$end = \App\Model\End::with('location')
	                          ->with('user')
	                          ->with('end1_connections')
	                          ->with('end2_connections')
	                          ->where('id',$id)
	                          ->get()
	                          ->toArray();

	    //
	    if(isset($end[0])){
		        $end[0]['end_connections'] = array_merge($end[0]['end1_connections'], $end[0]['end2_connections']);
			    unset($end[0]['end1_connections']);
			    unset($end[0]['end2_connections']);
			    return response()->json($end[0]);
	    }
	    else{

                return response()->json(['message'=>'Id not Found'],404); 
	    }
    }

	/**
	 * Show the form for editing the specified resource.
	 *
	 * @param  int  $id
	 * @return Response
	 */
	public function edit($id)
	{
		//
	}

	/**
	 * Update the specified resource in storage.
	 *
	 * @param  int  $id
	 * @return Response
	 */
	public function update(CreateEndFormRequest $request,$id)
	{
		 $result =  \App\Model\End::where('id',$id)->update($request->only('name','location_id','longitude','lattitude'));
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
		  $result = \App\Model\End::destroy($id);
		  if($result)
	    	    return response()->json(['message'=>'Deleted'],200);
	      else
	            return response()->json(['message'=>'Not Found'],404);
	}

}
