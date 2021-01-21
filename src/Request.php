<?php


namespace Remcodex\Server;


use Psr\Http\Message\ServerRequestInterface;

class Request
{
    private static ServerRequestInterface $request;

    public static function init(ServerRequestInterface $request): void
    {
        self::$request = $request;
    }

    public static function expectsJson(): bool
    {
        return true;
    }

    public static function expectsHtml(): bool
    {
        return true;
    }

    public static function getServerRequest(): ServerRequestInterface
    {
        return self::$request;
    }
}