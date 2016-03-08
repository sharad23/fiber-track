<?php namespace App\Events;

use App\Events\Event;

use Illuminate\Queue\SerializesModels;

class UpdateFiberConnectionCore extends Event {

	use SerializesModels;

	/**
	 * Create a new event instance.
	 *
	 * @return void
	 */
	public function __construct($core_id)
	{
	    $this->core_id = $core_id;
	}

}
