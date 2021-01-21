# RCE Server
Remote code execution server - this library uses [Guzwrap](https://github.com/Ahmard/guzwrap) to deconstruct sent request, perform it, and then send back request response to
[RCE Client](https://github.com/remcodex/client). <br/>
This library act like slave, except that it only support [Guzwrap](https://github.com/Ahmard/guzwrap) request objects at the moment.

## Installation
```bash
composer require remcodex/server
```

## Usage
```php
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
```

### Events
- App Events
```php
use Remcodex\Server\Events\AppEvent;


AppEvent::onError(function (Throwable $exception){
    echo "Error: {$exception->getMessage()} \n";
});
```

- Http Events

```php
use Psr\Http\Message\ServerRequestInterface;
use QuickRoute\Route\DispatchResult;
use Remcodex\Server\Events\HttpEvent;
use Remcodex\Server\Response\ResponseInterface;

HttpEvent::onRequest(function (ServerRequestInterface $request){
    echo "Request received: [{$request->getMethod()}] {$request->getUri()} \n";
});

HttpEvent::onDispatch(function (DispatchResult $dispatchResult){
    echo "Route dispatched: {$dispatchResult->getRoute()->getPrefix()} \n";
});

HttpEvent::onResponse(function (ResponseInterface $response){
    echo "Response about to be sent: {$response->getStatusCode()} \n";
});
```