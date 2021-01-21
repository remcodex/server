<?php


namespace Remcodex\Server\Router;


use Psr\Http\Message\ServerRequestInterface;
use QuickRoute\Route\Collector;
use QuickRoute\Route\Dispatcher as QuickRouteDispatcher;
use QuickRoute\Route\DispatchResult;
use Remcodex\Server\Event;

class Dispatcher
{
    private static DispatchResult $dispatchResult;

    public static function dispatch(ServerRequestInterface $request, Collector $collector): DispatchResult
    {
        $path = $request->getUri()->getPath();
        $method = $request->getMethod();

        if (!$collector->isRegistered()){
            $collector->register();
        }

        self::$dispatchResult =
            QuickRouteDispatcher::create($collector)
                ->dispatch($method, $path);

        //Dispatch http-dispatch event
        Event::emit(Event::HTTP_ROUTER_DISPATCH, self::$dispatchResult);

        return self::$dispatchResult;
    }

    public static function getDispatchResult(): DispatchResult
    {
        return self::$dispatchResult;
    }
}