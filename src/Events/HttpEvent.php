<?php


namespace Remcodex\Server\Events;


use Remcodex\Server\Event;

class HttpEvent
{
    public static function onRequest(callable $listener): void
    {
        Event::register(Event::HTTP_REQUEST, $listener);
    }

    public static function onResponse(callable $listener): void
    {
        Event::register(Event::HTTP_RESPONSE, $listener);
    }

    public static function onDispatch(callable $listener): void
    {
        Event::register(Event::HTTP_ROUTER_DISPATCH, $listener);
    }

    public static function onError(callable $listener): void
    {
        Event::register(Event::APP_ERROR, $listener);
    }
}