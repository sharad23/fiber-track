<?php namespace App\Http\Controllers;

use App\Http\Requests;
use App\Http\Controllers\Controller;

use Illuminate\Http\Request;

class User extends Controller {

	/**
	 * Display a listing of the resource.
	 *
	 * @return Response
	 */
	public function index()
	{
		$users = \App\Model\User::get()
		                         ->toArray();
		return response()->json($users);
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
		$password = \Hash::make($request->input('password'));
		$user = \App\Model\User::create(['username'=>$request->input('username'),'email'=>$request->input('email'),'password'=>$password,'name'=>$request->input('email')]);
        return response()->json($user);
	}

	/**
	 * Display the specified resource.
	 *
	 * @param  int  $id
	 * @return Response
	 */
	public function show($id)
	{
		$user = \App\Model\User::where('id',$id)
		                        ->get()
		                        ->toArray();
		return response()->json($user);
	}

	/**
	 * Show the form for editing the specified resource.
	 *
	 * @param  int  $id
	 * @return Response
	 */
	public function edit($id)
	{
		$users = \App\Model\User::where('id',$id)
		                         ->get()
		                         >toArray();
		return response()->json($user);
	}

	/**
	 * Update the specified resource in storage.
	 *
	 * @param  int  $id
	 * @return Response
	 */
	public function update($id,Request $request)
	{
		$result = \App\Model\User::where('id',$id)
		                         ->update($request->only('name','username','email'));
		if($result)
			 return response()->json(['message'=>'Updated'],200);
	    else
              return response()->json(['message'=>'Id Not Found'],404);
	}

	/**
	 * Remove the specified resource from storage.
	 *
	 * @param  int  $id
	 * @return Response
	 */
	public function destroy($id)
	{
		$result = \App\Model\User::destroy($id);
        if($result)
			 return response()->json(['message'=>'Updated'],200);
	    else
              return response()->json(['message'=>'Id Not Found'],404);
	}

}
