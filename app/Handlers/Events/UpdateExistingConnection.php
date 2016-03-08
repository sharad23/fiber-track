<?php namespace App\Handlers\Events;

use App\Events\FiberBreak;

use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Contracts\Queue\ShouldBeQueued;

class UpdateExistingConnection {

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
	 * @param  FiberBreak  $event
	 * @return void
	 */
	public function handle(FiberBreak $event)
	{
		return 'jyotsna'; //$event;
	}

}
