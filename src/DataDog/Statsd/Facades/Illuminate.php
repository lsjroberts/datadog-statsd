<?php namespace DataDog\Statsd\Facades;

use Illuminate\Support\Facades\Facade;

class Illuminate extends Facade {

	/**
	 * Get the registered name of the component.
	 *
	 * @return  string
	 */
	protected static function getFacadeAccessor() { return 'statsd'; }

}