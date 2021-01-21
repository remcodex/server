<?php


namespace Remcodex\Server;


use Remcodex\Server\Command\BaseCommand;

class Command
{
    /**
     * @var array<BaseCommand> $commands
     */
    private static array $commands;


    public static function register(BaseCommand $command): void
    {
        self::$commands[] = $command;
    }

    public static function load(string $filePath): array
    {
        if (!file_exists($filePath)){
            throw new \InvalidArgumentException("command definition \"{$filePath}\" does not exists.");
        }

        require $filePath;

        return self::getCommands();
    }

    public static function getCommands(): array
    {
        return self::$commands;
    }
}