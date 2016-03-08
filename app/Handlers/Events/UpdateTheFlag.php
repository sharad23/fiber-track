<?php namespace App\Handlers\Events;

use App\Events\UpdateFiberConnectionCore;

use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Contracts\Queue\ShouldBeQueued;

class UpdateTheFlag {

	/**
	 * Create the event handler.
	 *
	 * @return void
	 */
	public function __construct()
	{
		//
	}

	/**
	 * Handle the event.
	 *
	 * @param  UpdateFiberConnectionCore  $event
	 * @return void
	 */
	public function handle(UpdateFiberConnectionCore $event)
	{
		 \App\Model\FiberConnectionCore::where('id',$event->core_id)
		                               ->update(['flag' => 1]);
	}

}
