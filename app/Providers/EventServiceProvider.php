<?php namespace App\Providers;

use Illuminate\Contracts\Events\Dispatcher as DispatcherContract;
use Illuminate\Foundation\Support\Providers\EventServiceProvider as ServiceProvider;

class EventServiceProvider extends ServiceProvider {

	/**
	 * The event handler mappings for the application.
	 *
	 * @var array
	 */
	protected $listen = [
		'event.name' => [
			'EventListener',
		],
	];

	/**
	 * Register any other events for your application.
	 *
	 * @param  \Illuminate\Contracts\Events\Dispatcher  $events
	 * @return void
	 */

	public function boot(DispatcherContract $events)
	{
		parent::boot($events);
       /* \App\Model\Fiber::deleting(function($fiber)
	    {
	         \App\Model\FiberCore::where('fiber_id',$fiber->id)->delete();
	    });*/
        \App\Model\FiberConnection::observe(new \App\Observers\FiberConnectionObserver);
        \App\Model\Fiber::observe(new \App\Observers\FiberObserver);
        \App\Model\End::observe(new \App\Observers\EndObserver);
		
	}

}
