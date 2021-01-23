<?php


namespace Remcodex\Server;


use Laminas\Diactoros\ServerRequestFactory;
use Laminas\Stratigility\MiddlewarePipe;
use QuickRoute\Route\Collector;
use Remcodex\Server\Command\BaseCommand;
use Remcodex\Server\Events\HttpEvent;
use Remcodex\Server\Middlewares\HttpRoutingMiddleware;
use Remcodex\Server\Middlewares\PayloadDecoderBaseMiddleware;

class Server
{
    public const ENV_PRODUCTION = 'production';
    public const ENV_DEVELOPMENT = 'development';

    private array $errorHandlers = [];
    private array $commands;
    private string $environment;
    private Collector $routeCollector;

    public function __construct()
    {
        $this->environment = self::ENV_DEVELOPMENT;
    }

    public static function create(): Server
    {
        set_exception_handler(new ErrorHandler());
        return new Server();
    }

    public function setErrorHandler(callable $handler): Server
    {
        $this->errorHandlers[] = $handler;
        return $this;
    }

    public function setEnvironment(string $environment): Server
    {
        $this->environment = $environment;
        return $this;
    }

    public function setRouteCollector(Collector $collector): Server
    {
        $this->routeCollector = $collector;
        return $this;
    }

    /**
     * @param array<BaseCommand> $commands
     * @return $this
     */
    public function setCommands(array $commands): Server
    {
        $this->commands = $commands;
        return $this;
    }

    public function onRequest(callable $listener): Server
    {
        HttpEvent::onRequest($listener);
        return $this;
    }

    public function onResponse(callable $listener): Server
    {
        HttpEvent::onResponse($listener);
        return $this;
    }

    public function run(): void
    {
        $request = ServerRequestFactory::fromGlobals();
        Request::init($request);

        //Emit request event
        Event::emit(Event::HTTP_REQUEST, $request);

        //BaseMiddleware
        $middlewareRunner = new MiddlewarePipe();
        $middlewareRunner->pipe(new PayloadDecoderBaseMiddleware());
        $middlewareRunner->pipe(new HttpRoutingMiddleware($this->routeCollector));
        $response = $middlewareRunner->handle($request);

        ResponseGenerator::generate($response)->send($request);
    }
}