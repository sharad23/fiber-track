<?php namespace App\Http\Controllers;

use App\Http\Requests\CreateLocationFormRequest;
use App\Http\Requests\UpdateLocationFormRequest;
use App\Http\Controllers\Controller;

use Illuminate\Http\Request;

class Location extends Controller {

	/**
	 * Display a listing of the resource.
	 *
	 * @return Response
	 */
	public function index()
	{
	    $locations =  \App\Model\Location::all();
	    return response()->json($locations);

	}

	/**
	 * Show the form for creating a new resource.
	 *
	 * @return Response
	 */
	public function create()
	{
	
	}

	/**
	 * Store a newly created resource in storage.
	 *
	 * @return Response
	 */
	public function store(CreateLocationFormRequest $request)
	{
		 $location = new \App\Model\Location($request->only('user_id','name'));
		 $location->user_id = \Auth::user()->id;
		 $location->save();
		 return response()->json($location,200);

	}

	/**
	 * Display the specified resource.
	 *
	 * @param  int  $id
	 * @return Response
	 */
	public function show($key)
	{
		$location =  \App\Model\Location::where('name', 'LIKE', "$key%")->get()->toArray();
	    return response()->json($location);
	}

	/**
	 * Show the form for editing the specified resource.
	 *
	 * @param  int  $id
	 * @return Response
	 */
	public function edit($id)
	{
		
	    $location =  \App\Model\Location::where('id',$id)->get()->toArray();
	    return response()->json($location);
	}

	/**
	 * Update the specified resource in storage.
	 *
	 * @param  int  $id
	 * @return Response
	 */
	public function update($id,UpdateLocationFormRequest $request)
	{
		$result = \App\Model\Location::where('id', $id)->update(['name' => $request->input('name')]);
		if($result) 
		       return response()->json(['message'=>'Updated'],200);
		else
		       return response()->json(['message'=>'Data Not Found'],404);                  
	} 

	/**
	 * Remove the specified resource from storage.
	 *
	 * @param  int  $id
	 * @return Response
	 */
	public function destroy($id)
	{
		//
	}

}
