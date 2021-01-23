<?php


namespace Remcodex\Server;


use JsonSerializable;
use Nette\Utils\Json;
use Nette\Utils\JsonException;
use Psr\Http\Message\ServerRequestInterface;
use Remcodex\Server\Exceptions\InvalidPayloadException;

class Payload implements JsonSerializable
{
    private string $command;
    private array $guzwrapRequestData;

    /**
     * Payload constructor.
     * @param ServerRequestInterface $serverRequest
     * @throws InvalidPayloadException
     * @throws JsonException
     */
    public function __construct(ServerRequestInterface $serverRequest)
    {
        $requestBody = $serverRequest->getBody()->getContents();
        $requestArray = Json::decode($requestBody, Json::FORCE_ARRAY);

        //Command check
        if (!isset($requestArray['command'])) {
            throw new InvalidPayloadException("Request command most be defined");
        }

        //Guzwrap request check
        if (!isset($requestArray['guzwrap'])) {
            throw new InvalidPayloadException("Guzwrap request object most be defined");
        }

        $this->command = $requestArray['command'];
        $this->guzwrapRequestData = Json::decode($requestArray['guzwrap'], Json::FORCE_ARRAY);
    }

    public function command(): string
    {
        return $this->command;
    }

    public function guzwrap(): array
    {
        return $this->guzwrapRequestData;
    }

    public function jsonSerialize(): array
    {
        return [
            'command' => $this->command,
            'guzwrap' => $this->guzwrapRequestData,
        ];
    }
}