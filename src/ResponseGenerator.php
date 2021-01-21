<?php


namespace Remcodex\Server;


use Psr\Http\Message\ResponseInterface as PsrResponseInterface;
use Psr\Http\Message\ServerRequestInterface;
use Psr\Http\Message\StreamInterface;

class ResponseGenerator
{
    private PsrResponseInterface $response;

    public function __construct(PsrResponseInterface $response)
    {
        $this->response = $response;
    }

    public static function generate(PsrResponseInterface $response): ResponseGenerator
    {
        return new self($response);
    }

    public function send(ServerRequestInterface $request): void
    {
        //Emit response event
        Event::emit(Event::HTTP_RESPONSE, $this->response);

        //Send response to client
        echo $this->__invoke($request)->getContents();
        exit($this->response->getStatusCode());
    }

    public function __invoke(ServerRequestInterface $request): StreamInterface
    {
        $version = $this->response->getProtocolVersion();
        $statusCode = $this->response->getStatusCode();
        $reasonPhrase = $this->response->getReasonPhrase();

        if (!headers_sent()) {
            header("HTTP/{$version} {$statusCode} {$reasonPhrase}", true, $statusCode);
            header('X-Powered-By: ' . Config::appName());
            foreach ($this->response->getHeaders() as $headerName => $headerValues) {
                $headerValues = implode(' ', $headerValues);
                header("{$headerName}: {$headerValues}");
            }
        }

        return $this->response->getBody();
    }
}