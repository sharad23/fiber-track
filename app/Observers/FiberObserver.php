<?php namespace App\Observers;
     
       class FiberObserver {

		    public function deleting($fiber)
		    {
		          \App\Model\FiberCore::where('fiber_id',$fiber->id)->delete();
		    }

		    public function deleted($fiberl)
		    {
		        
		    }

       }

?>
