<?php


namespace Remcodex\Server\Response;


use Remcodex\Server\Exceptions\Error;
use Throwable;

final class InternalServerErrorResponse extends BaseResponse
{
    public static function create(?Throwable $exception = null): ResponseInterface
    {
        $error = Error::create($exception)->getMessage() ?? 'Internal server error.';
        return (new static())->withResponse(
            MultiPurposeResponse::create()
                ->withStatus(500, 'internal server error.')
                ->withJson([
                    'status' => false,
                    'message' => $error
                ])
        );
    }
}