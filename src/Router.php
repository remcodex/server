<?php


namespace Remcodex\Server;


use QuickRoute\Route\Collector;

class Router
{
    public static function load(string $routeFile): Collector
    {
        if (!file_exists($routeFile)){
            throw new \InvalidArgumentException("route definition \"{$routeFile}\" does not exists.");
        }

        return Collector::create()->collectFile($routeFile);
    }
}