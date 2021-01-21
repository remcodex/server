<?php

use Remcodex\Server\Event;
use Remcodex\Server\Events\HttpEvent;

require 'vendor/autoload.php';

Event::init();

HttpEvent::onRequest(function (){
    echo 'Request Received'.PHP_EOL;
});

HttpEvent::onResponse(function (){
    echo 'Response sent'.PHP_EOL;
});

Event::emit(Event::HTTP_REQUEST);