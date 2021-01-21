<?php


namespace Remcodex\Server\Router;

use Exception;
use Psr\Http\Message\ServerRequestInterface;
use QuickRoute\Route\DispatchResult;
use Remcodex\Server\Config;
use Remcodex\Server\ErrorHandler;
use Remcodex\Server\Response\InternalServerErrorResponse;
use Remcodex\Server\Response\ResponseInterface;
use Throwable;

class Matcher
{
    public static function match(ServerRequestInterface $request, DispatchResult $dispatchResult): ResponseInterface
    {
        return Matcher::route($request, $dispatchResult);
    }

    private static function route(ServerRequestInterface $request, DispatchResult $dispatchResult): ResponseInterface
    {
        $routeData = $dispatchResult->getRoute();
        $requestParams = $dispatchResult->getUrlParameters();

        //Handle controller
        $controller = $routeData->getHandler();

        $explodedController = explode('@', $controller);
        $controllerClass = $explodedController[0];
        $controllerMethod = $explodedController[1];

        $namespacedController = Config::defaultControllerNamespace()
            . $routeData->getNamespace()
            . $controllerClass;

        //Call defined method
        $instantiatedController = (new $namespacedController());

        if (!method_exists($instantiatedController, $controllerMethod)) {
            throw new Exception("Method {$namespacedController}::{$controllerMethod}() does not exists.");
        }

        $response = InternalServerErrorResponse::create();

        try {
            $response = call_user_func(
                [
                    $instantiatedController,
                    $controllerMethod
                ],
            );
        } catch (Throwable $exception) {
            ErrorHandler::handle($exception);
        }

        return $response;
    }
}