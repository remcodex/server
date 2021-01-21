<?php


namespace Remcodex\Server\Prebuilt;


use Remcodex\Server\Command\CommandHandlerInterface;

class HttpCommandHandler implements CommandHandlerInterface
{

    public function handle(): void
    {
        echo 'Something happened';
    }
}