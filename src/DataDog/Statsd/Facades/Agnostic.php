<?php namespace DataDog\Statsd\Facades;

class Agnostic
{
    public static $instance = null;

    public static function getInstance()
    {
        if (static::$instance === null) static::$instance = new static;
        return static::$instance;
    }

    public static function __callStatic($method, $parameters)
    {
        $instance = static::getInstance();
        $callable = array($instance, $method);

        return call_user_func_array($callable, $parameters);
    }

}