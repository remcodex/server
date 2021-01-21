<?php


namespace Remcodex\Server\Controllers;


use Remcodex\Server\Response\JsonResponse;
use Remcodex\Server\Response\ResponseInterface;

class MainController
{
    public function index(): ResponseInterface
    {
        return JsonResponse::success([time()]);
    }
}