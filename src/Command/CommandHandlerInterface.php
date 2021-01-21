<?php


namespace Remcodex\Server\Command;


interface CommandHandlerInterface
{
    public function handle(): void;
}