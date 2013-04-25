<?php namespace DataDog\Statsd;

use Illuminate\Support\ServiceProvider;

class StatsdServiceProvider extends ServiceProvider {

	/**
	 * Indicates if loading of the provider is deferred.
	 *
	 * @var bool
	 */
	protected $defer = false;

	/**
	 * Bootstrap the application events.
	 *
	 * @return void
	 */
	public function boot()
	{
		$this->package('datadog/statsd');
	}

	/**
	 * Register the service provider.
	 *
	 * @return void
	 */
	public function register()
	{
		$this->app['statsd'] = $this->app->share(function($app)
		{
			$statsd = new Statsd;
			$statsd->datadogHost = $app['config']->get('statsd::host');
			$statsd->eventUrl = $app['config']->get('statsd::event_url');
			$statsd->apiKey = $app['config']->get('statsd::api_key');
			$statsd->applicationKey = $app['config']->get('statsd::application_key');

			return $statsd;
		});
	}

	/**
	 * Get the services provided by the provider.
	 *
	 * @return array
	 */
	public function provides()
	{
		return array('statsd');
	}

}