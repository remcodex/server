<?php


namespace Remcodex\Server\Response;


final class MethodNotAllowedResponse extends BaseResponse
{
    public static function create(): ResponseInterface
    {
        return (new MethodNotAllowedResponse())->withResponse(
            MultiPurposeResponse::create()
                ->withStatus(405, 'method not allowed')
                ->withJson([
                    'message' => 'Request method not allowed.'
                ])
        );
    }
}