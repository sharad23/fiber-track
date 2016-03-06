<?php namespace App\Observers;
     
       class EndObserver {

		    public function deleting($end)
		    {
		          \App\Model\FiberConnection::where('end1',$end->id)->delete();
		          \App\Model\FiberConnection::where('end2',$end->id)->delete();
		    }

		    public function deleted($fiberl)
		    {
		        
		    }

       }

?>
