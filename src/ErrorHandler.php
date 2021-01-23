<?php


namespace Remcodex\Server;


use Throwable;

class ErrorHandler
{
    public static function handle(Throwable $exception): void
    {
        (new ErrorHandler())->__invoke($exception);
    }

    public function __invoke(Throwable $exception): void
    {
        Event::emit(Event::APP_ERROR, $exception);
        Helper::stdout($exception->__toString());
    }
}