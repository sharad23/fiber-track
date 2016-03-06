<?php namespace App\Http\Controllers;

use App\Http\Requests\CreateColorFormRequest;
use App\Http\Requests\UpdateColorFormRequest;
use App\Http\Requests;
use App\Http\Controllers\Controller;

use Illuminate\Http\Request;

class Color extends Controller {

	/**
	 * Display a listing of the resource.
	 *
	 * @return Response
	 */
	public function index(Request $request)
	{   
		
		$colors =  \App\Model\Color::all();
		
		return response()->json($colors);
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
	public function store(CreateColorFormRequest $request)
	{   

		$color =  new \App\Model\Color($request->only('name','hexcode'));
		$color->user_id = \Auth::user()->id;
		$color->save();
        return response()->json($color);
	}

	/**
	 * Display the specified resource.
	 *
	 * @param  int  $id
	 * @return Response
	 */
	public function show($key)
	{
	    $color =  \App\Model\Color::where('name', 'LIKE', "$key%")->get()->toArray();
	    return response()->json($color);
	}

	/**
	 * Show the form for editing the specified resource.
	 *
	 * @param  int  $id
	 * @return Response
	 */
	public function edit($id)
	{
		$location =  \App\Model\Color::where('id',$id)->get()->toArray();
	    return response()->json($location);
	}

	/**
	 * Update the specified resource in storage.
	 *
	 * @param  int  $id
	 * @return Response
	 */
	public function update(UpdateColorFormRequest $request,$id)
	{
		$result = \App\Model\Color::where('id', $id)->update($request->only('name','hexcode'));
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
		$result = \App\Model\Color::destroy($id);
		if($result) 
		       return response()->json(['message'=>'deleted'],200);
		else
		       return response()->json(['message'=>'Data Not Found'],404); 
	}

}
