<?php


namespace Remcodex\Server\Controllers\Api\Http;


use Remcodex\Server\Request;
use Remcodex\Server\Response\JsonResponse;
use Remcodex\Server\Response\ResponseInterface;

class RequestController
{
    public function request(): ResponseInterface
    {
        return JsonResponse::success(Request::getServerRequest()->getUri());
    }
}