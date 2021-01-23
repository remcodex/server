<?php


namespace Remcodex\Server;


use Evenement\EventEmitter;
use Evenement\EventEmitterInterface;

class Event
{
    public const APP_ERROR = 'app.error';
    public const HTTP_REQUEST = 'http.request';
    public const HTTP_RESPONSE = 'http.response';
    public const HTTP_ROUTER_DISPATCH = 'http.router.dispatch';
    private static EventEmitterInterface $eventEmitter;

    /**
     * Register an event
     * @param string $name
     * @param callable $listener
     */
    public static function register(string $name, callable $listener): void
    {
        self::getEmitter()->on($name, $listener);
    }

    protected static function getEmitter(): EventEmitterInterface
    {
        self::init();;
        return self::$eventEmitter;
    }

    /**
     * Initialise event listening object
     * This method should be called once, i.e during app construction
     */
    public static function init(): void
    {
        if (!isset(self::$eventEmitter)) {
            self::$eventEmitter = new EventEmitter();
        }
    }

    /**
     * Emit an event
     * @param string $name
     * @param mixed ...$eventData
     */
    public static function emit(string $name, ...$eventData): void
    {
        self::getEmitter()->emit($name, $eventData);
    }
}