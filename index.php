<?php

use Remcodex\Server\Command;
use Remcodex\Server\ErrorHandler;
use Remcodex\Server\Prebuilt\RequestListener;
use Remcodex\Server\Prebuilt\ResponseListener;
use Remcodex\Server\Router;
use Remcodex\Server\Server;

require 'vendor/autoload.php';

//Load http routes
$collector = Router::load(__DIR__ . '/routes.php');

//Load request commands
$commands = Command::load(__DIR__ . '/commands.php');

//Create and start server
Server::create()
    ->setEnvironment(Server::ENV_DEVELOPMENT)
    ->setErrorHandler(new ErrorHandler())
    ->setRouteCollector($collector)
    ->setCommands($commands)
    ->onRequest(new RequestListener())
    ->onResponse(new ResponseListener())
    ->run();