<?php


namespace Remcodex\Server\Response;


use Psr\Http\Message\StreamInterface;
use Throwable;

final class JsonResponse extends BaseResponse
{
    /**
     * Respond with success response
     * @param mixed $data An array or object
     * @return ResponseInterface
     */
    public static function success($data): ResponseInterface
    {
        return JsonResponse::create([
            'success' => true,
            'data' => $data
        ]);
    }

    /**
     * @param array|object $body
     * @return ResponseInterface
     */
    public static function create($body = []): ResponseInterface
    {
        //Define responder
        if (is_array($body)) {
            $body['responder'] = 'rce.server';
        } elseif (is_object($body)) {
            $body->responder = 'rce.server';
        }

        return (new JsonResponse())->withJson($body)
            ->withAddedHeader('Content-Type', 'application/json');
    }

    /**
     * Respond with error response
     * @param array|string|Throwable $errorData An error message
     * @return ResponseInterface
     */
    public static function error($errorData): ResponseInterface
    {
        return JsonResponse::create([
            'success' => false,
            'error' => $errorData
        ]);
    }

    /**
     * @param array|object $body
     * @return ResponseInterface
     */
    public function withBody($body = []): ResponseInterface
    {
        return $this->withJson($body);
    }

    public function getBody(): StreamInterface
    {
        //This method will be recursively called,
        //so we need to know when to quit.
        static $willReturn = false;
        if ($willReturn) {
            return parent::getBody();
        }

        $willReturn = true;
        return $this->writeBodyStream($this->getJson())->getBody();
    }
}