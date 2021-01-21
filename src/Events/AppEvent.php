<?php


namespace Remcodex\Server\Events;


use Remcodex\Server\Event;

class AppEvent
{
    public static function onError(callable $listener): void
    {
        Event::register(Event::APP_ERROR, $listener);
    }
}