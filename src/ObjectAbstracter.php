<?php


namespace Remcodex\Server;


class ObjectAbstracter
{
    private static Payload $payload;

    /**
     * @return Payload
     */
    public static function getPayload(): Payload
    {
        return self::$payload;
    }

    /**
     * @param Payload $payload
     */
    public static function setPayload(Payload $payload): void
    {
        self::$payload = $payload;
    }
}