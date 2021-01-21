<?php


namespace Remcodex\Server\Middlewares;


use Psr\Http\Message\ResponseInterface;
use Psr\Http\Message\ServerRequestInterface;
use Psr\Http\Server\RequestHandlerInterface;
use QuickRoute\Route\Collector;
use Remcodex\Server\Response\InternalServerErrorResponse;
use Remcodex\Server\Response\MethodNotAllowedResponse;
use Remcodex\Server\Response\NotFoundResponse;
use Remcodex\Server\Router\Dispatcher;
use Remcodex\Server\Router\Matcher;

class HttpRoutingMiddleware extends BaseMiddleware
{
    private Collector $collector;


    public function __construct(Collector $collector)
    {
        $this->collector = $collector;
    }

    public function process(ServerRequestInterface $request, RequestHandlerInterface $handler): ResponseInterface
    {
        $dispatchResult = Dispatcher::dispatch($request, $this->collector);

        switch (true) {
            case $dispatchResult->isFound():
                $response = Matcher::match($request, $dispatchResult);
                break;
            case $dispatchResult->isNotFound():
                $response = NotFoundResponse::create();
                break;
            case $dispatchResult->isMethodNotAllowed():
                $response = MethodNotAllowedResponse::create();
                break;
            default:
                $response = InternalServerErrorResponse::create();
        }

        return $response;
    }
}