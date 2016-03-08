<?php namespace App\Http\Controllers;

use App\Http\Requests\CreateClientFormRequest;
use App\Http\Controllers\Controller;

use Illuminate\Http\Request;

class Client extends Controller {

	/**
	 * Display a listing of the resource.
	 *
	 * @return Response
	 */
	public function index()
	{
		$clients =  \App\Model\Client::with('user')
		                            ->with('location')
		                            ->with('pod')
		                            ->get()
		                            ->toArray();

		return response()->json($clients);

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
	public function store(CreateClientFormRequest $request)
	{
		$client = \App\Model\Client::create($request->only('name','location_id','service_type','core_type','longitude','lattitude','pod_id'));
	    //Model event is generated after the insertion of client
        return response()->json($client);

	}

	/**
	 * Display the specified resource.
	 *
	 * @param  int  $id
	 * @return Response
	 */
	public function show($id)
	{
		$client =  \App\Model\Client::with('connections')
		                            ->with('user')
		                            ->with('pod')
		                            ->with('location')
		                            ->where('id',$id)
		                            ->get();

		return response()->json($client);

	}

	/**
	 * Show the form for editing the specified resource.
	 *
	 * @param  int  $id
	 * @return Response
	 */
	public function edit($id)
	{
		$client =  \App\Model\Client::with('connections')
		                            ->with('user')
		                            ->with('pod')
		                            ->with('location')
		                            ->where('id',$id)
		                            ->get();

		return response()->json($client);
	}

	/**
	 * Update the specified resource in storage.
	 *
	 * @param  int  $id
	 * @return Response
	 */
	public function update($id,CreateClientFormRequest $request)
	{   

		
		$result = \App\Model\Client::where('id',$id)
		                           ->update($request->only('name','location_id','service_type','core_type','longitude','lattitude','pod_id'));
	    
	    if(!$result){

	    	 return response()->json(['message'=>'Id not found'],404);
	    }
        foreach($request->input('client_conn_id') as $key => $row){

	    	  $conn = \App\Model\ClientConnection::find($row) ?: new \App\Model\ClientConnection();
	    	  \App\Model\FiberConnectionCore::whereIn('id',[ $conn->connection_core_id1,$conn->connection_core_id2])
	    	                                ->update(['flag' => 0 ]);
	    	  $conn->connection_id = $request->input('connection_id')[$key];
	    	  $conn->order = $key+1;
	    	  $conn->connection_core_id1 = $request->input('connection_core_id1')[$key];
	    	  $conn->connection_core_id2 = $request->input('connection_core_id2')[$key];
	    	  $conn->client_id = $id;
	    	  $conn->save();
	    	  $conn_ids[] = $conn->id;
	    	  //update the flag
	    	  \App\Model\FiberConnectionCore::whereIn('id',[$conn->connection_core_id1,$conn->connection_core_id2])
	    	                           ->update(['flag' => 1]);
        }
        
        //get the unused conn of the client
        $altered_conn = \App\Model\ClientConnection::where('client_id',$id)
				                                   ->whereNotIn('id',$conn_ids)
				                                   ->get();
	    
	    $altered_core_ids = [];		                                   
        foreach($altered_conn as $row){

        	 $altered_core_ids[] = $row['connection_core_id1'];
        	 $altered_core_ids[] = $row['connection_core_id2'];
        	
        }
        \App\Model\ClientConnection::where('client_id',$id)
				                   ->whereNotIn('id',$conn_ids)
				                   ->delete();

        \App\Model\FiberConnectionCore::whereIn('id', $altered_core_ids)
	    	                     ->update(['flag' => 0]);
        
         return response()->json(['message'=>'Success']);
	}

	/**
	 * Remove the specified resource from storage.
	 *
	 * @param  int  $id
	 * @return Response
	 */
	public function destroy($id)
	{
		$result = \App\Model\Client::destroy($id);
		if($result)
			 return response()->json(['message' => 'Deleted']);
	    else
	    	 return response()->json(['message' => 'Id not Found'],404);
	}

}
