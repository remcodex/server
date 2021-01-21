<?php


namespace Remcodex\Server\Command;


class HttpCommand extends BaseCommand
{
    public function __construct(string $commandName)
    {
        parent::__construct('http.' . $commandName);
    }
}