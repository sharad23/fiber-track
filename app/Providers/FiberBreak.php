<?php namespace App\Providers;

use App\Events\Event;

use Illuminate\Queue\SerializesModels;

class FiberBreak extends Event {

	use SerializesModels;

	/**
	 * Create a new event instance.
	 *
	 * @return void
	 */
	public function __construct()
	{
		//
	}

}
