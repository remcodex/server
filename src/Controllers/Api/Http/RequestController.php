<?php


namespace Remcodex\Server\Controllers\Api\Http;


use Remcodex\Server\Request;
use Remcodex\Server\Response\JsonResponse;
use Remcodex\Server\Response\ResponseInterface;

class RequestController
{
    public function request(): ResponseInterface
    {
        $response = \Guzwrap\Request::useRequestData(Request::getPayload()->guzwrap())->exec();
        return JsonResponse::success($response->getBody()->getContents());
    }
}