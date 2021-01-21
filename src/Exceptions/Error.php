<?php


namespace Remcodex\Server\Exceptions;


use Exception;
use Remcodex\Server\Config;
use Throwable;

class Error extends Exception
{
    protected Throwable $exception;


    public static function create(?Throwable $exception): Error
    {
        if ('development' !== Config::environment()) {
            return new Error($exception);
        }

        return new Error('Server ran in to an error while processing your request.');
    }
}