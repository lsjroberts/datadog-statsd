PHP DataDog Statsd Client
=========================

Forked from [https://github.com/DataDog/php-datadogstatsd](https://github.com/DataDog/php-datadogstatsd).


Installation
------------

### Composer

Add the following to your `composer.json`:

```
"lsjroberts/datadog-statsd": "1.0.*"
```


Setup
-----

### Laravel 4

Add the service provider to your Laravel application in `app/config/app.php`. In the `providers` array add:

```
'DataDog\Statsd\StatsdServiceProvider',
```

And then alias it by adding the facade to the `facades` array in the same file:

```
'Statsd' => 'DataDog\Statsd\Facades\Illuminate',
```


### Standalone

If you are using another framework or writing a standalone project you can just call:

```
use DataDog\Statsd\Facades\Agnostic as Statsd;
```


Usage
-----

### Increment

To increment things:

``` php
Statsd::increment('your.data.point');
Statsd::increment('your.data.point', .5);
Statsd::increment('your.data.point', 1, array('tagname' => 'value'));
```

### Decrement

To decrement things:

``` php
Statsd::decrement('your.data.point');
```

### Timing

To time things:

``` php
$start_time = microtime(true);
run_function();
Statsd::timing('your.data.point', microtime(true) - $start_time);

Statsd::timing('your.data.point', microtime(true) - $start_time, 1, array('tagname' => 'value'));
```

### Submitting events

Requires PHP >= 5.3.0 and the [PECL http](http://www.php.net/manual/en/http.install.php) extension

To submit events, you'll need to first configure the library with your
Datadog credentials, since the event function submits directly to Datadog
instead of sending to a local dogstatsd instance.

``` php
$apiKey = 'myApiKey';
$appKey = 'myAppKey';

Statsd::configure($apiKey, $appKey);
Statsd::event('A thing broke!', array(
	'alert_type'      => 'error',
	'aggregation_key' => 'test_aggr'
));
Statsd::event('Now it is fixed.', array(
	'alert_type'      => 'success',
	'aggregation_key' => 'test_aggr'
));
```

This is what you'd see your Datadog event stream:

![screenshot](https://img.skitch.com/20120817-c6pi1e55rs2xjt3ktp2k1h67e7.png)

You can find your api and app keys in the [API tab](https://app.datadoghq.com/account/settings#api).

For more documentation on the optional values of events, see [http://docs.datadoghq.com/api/#events/](http://docs.datadoghq.com/api/#events/).

Note that while sending metrics with this library is fast since it's sending
locally over UDP, sending events will be slow because it's sending data
directly to Datadog over HTTP. We'd like to improve this in the near future.



Original Author
---------------

Alex Corley - anthroprose@gmail.com