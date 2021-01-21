<?php


namespace Remcodex\Server\Command;


use Psr\Http\Server\MiddlewareInterface;

class CommandRoute
{
    private array $routeData;


    public static function create(): CommandRoute
    {
        return new CommandRoute();
    }

    /**
     * Web route path
     * @param string $routePath
     * @return CommandRoute
     */
    public function path(string $routePath): CommandRoute
    {
        $this->routeData['path'] = $routePath;
        return $this;
    }

    /**
     * Web request method
     * @param string $method
     * @return CommandRoute
     */
    public function method(string $method): CommandRoute
    {
        $this->routeData['method'] = $method;
        return $this;
    }

    /**
     * Web request middleware
     * @param MiddlewareInterface $middleware
     * @return CommandRoute
     */
    public function middleware(MiddlewareInterface $middleware): CommandRoute
    {
        $this->routeData['middleware'] = $middleware;
        return $this;
    }

    /**
     * @return array
     */
    public function getRouteData(): array
    {
        return $this->routeData;
    }
}