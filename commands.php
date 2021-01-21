<?php

use Remcodex\Server\Command\CommandRoute;
use Remcodex\Server\Command\HttpCommand;
use Remcodex\Server\Prebuilt\HttpCommandHandler;

HttpCommand::create('request')
    ->route(CommandRoute::create()->path('http'))
    ->handler(new HttpCommandHandler());