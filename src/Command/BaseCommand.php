<?php


namespace Remcodex\Server\Command;


use Remcodex\Server\Command;

abstract class BaseCommand
{
    private string $commandName;

    private CommandHandlerInterface $handler;
    private CommandRoute $commandRoute;

    public function __construct(string $commandName)
    {
        Command::register($this);
        $this->commandName = $commandName;
    }

    /**
     * @param string $commandName
     * @return static
     */
    public static function create(string $commandName): BaseCommand
    {
        return new static($commandName);
    }

    public function route(CommandRoute $commandRoute): BaseCommand
    {
        $this->commandRoute = $commandRoute;
        return $this;
    }

    public function handler(CommandHandlerInterface $commandHandler): BaseCommand
    {
        $this->handler = $commandHandler;
        return $this;
    }

    public function getCommandData(): array
    {
        return [
            'name' => $this->commandName,
            'route' => $this->commandRoute,
            'handler' => $this->handler,
        ];
    }
}