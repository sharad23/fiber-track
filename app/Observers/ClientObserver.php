<?php namespace App\Observers;
use Request;

     
       class ClientObserver {

            public function deleted($client)
		    {    

		    	 $client_conn =  $client->connections()
		    	                        ->get()
		    	                        ->toArray();
		    	 foreach($client_conn as $row){
		    	 	  $ids[] = $row['connection_core_id1'];
		    	 	  $ids[] = $row['connection_core_id2'];
		    	 	  $deleteIds[] = $row['id'];
		    	 } 
		        $result = \App\Model\FiberConnectionCore::whereIn('id', $ids)
		                                                ->update(['flag'=> 0]);
                

		        $result = \App\Model\ClientConnection::whereIn('id',$deleteIds)
		                                      ->delete();

            }

		    public function created($client){
                
                $i = 1;
                foreach(Request::input('connection_id') as $key => $row){

                	   $connections[] = new \App\Model\ClientConnection([
                	   	                  'connection_id' => $row,
                	   	                  'connection_core_id1' => Request::input('connection_core_id1')[$key],
                	   	                  'connection_core_id2' => Request::input('connection_core_id2')[$key],
                	   	                  'order' => $i,
                	   	                ]);

                	   $i++;
                }
                
                $core_conn = $client->connections()->saveMany($connections);
                //fire event to update the connection core
                foreach($core_conn as $row){
                     
                    \Event::fire(new \App\Events\UpdateFiberConnectionCore($row["connection_core_id1"]));
                    if($row["connection_core_id1"] == 0){
                    	 \Event::fire(new \App\Events\UpdateFiberConnectionCore($row["connection_core_id2"]));
                    }
                }

            }

        }

?>
