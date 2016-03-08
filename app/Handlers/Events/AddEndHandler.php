<?php namespace App\Handlers\Events;

use App\Events\AddEnd;

use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Contracts\Queue\ShouldBeQueued;

class AddEndHandler {

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
	 * @param  AddEnd  $event
	 * @return void
	 */
	public function handle(AddEnd $event)
	{
	    return $event;

	}

}
