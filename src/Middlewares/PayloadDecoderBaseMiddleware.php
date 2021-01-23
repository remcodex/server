<?php


namespace Remcodex\Server\Middlewares;


use Nette\Utils\JsonException;
use Psr\Http\Message\ResponseInterface;
use Psr\Http\Message\ServerRequestInterface;
use Psr\Http\Server\RequestHandlerInterface;
use Remcodex\Server\Exceptions\InvalidPayloadException;
use Remcodex\Server\ObjectAbstracter;
use Remcodex\Server\Payload;
use Remcodex\Server\Response\JsonResponse;

class PayloadDecoderBaseMiddleware extends BaseMiddleware
{
    public function process(ServerRequestInterface $request, RequestHandlerInterface $handler): ResponseInterface
    {
        try {
            ObjectAbstracter::setPayload(new Payload($request));
        } catch (JsonException | InvalidPayloadException $e) {
            return JsonResponse::error($e->getMessage());
        }

        return parent::process($request, $handler);
    }
}