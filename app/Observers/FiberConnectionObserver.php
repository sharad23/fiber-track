<?php namespace App\Observers;
     
       class FiberConnectionObserver {

  		    public function deleting($fiberConn)
  		    {
  		           $result = \App\Model\FiberConnectionCore::where('connection_id',$fiberConn->id)
  		                                    ->where('flag','!=','0')
  		                                    ->count();
                     if($result)
                        return false;
                     else
                     	  \App\Model\FiberConnectionCore::where('connection_id',$fiberConn->id)
                     	                                ->delete();
  		    }
          
          public function created($conn){

              $fiberCores = \App\Model\FiberCore::where('fiber_id',$conn->fiber_id)
                                           ->get();
              foreach($fiberCores as $core){
                   $connection_cores[] = new \App\Model\FiberConnectionCore(array('flag'=> 0,'color_id' => $core->color_id ));
              }
              $cores = $conn->cores()->saveMany($connection_cores);

          }

          public function updated($conn){

              echo '<pre>';
              print_r($conn);
              echo '</pre>';
          }

       }

?>
