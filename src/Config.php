<?php


namespace Remcodex\Server;


class Config
{
    public const APP_NAME = 'app_name';
    public const APP_ENV = 'app_environment';
    public const HTTP_CONTROLLER_NS = 'http_controller_ns';

    private static array $configurations = [
        'app_name' => 'Remcodex',
        'app_environment' => 'development',
    ];

    private static string $defaultControllerNamespace = 'Remcodex\\Server\\Controllers\\';


    public static function defaultControllerNamespace(): string
    {
        return self::$defaultControllerNamespace;
    }

    /**
     * Get app env type: development/production
     * @return string
     */
    public static function environment(): string
    {
        return self::$configurations[self::APP_ENV];
    }

    /**
     * Get app name
     * @return string
     */
    public static function appName(): string
    {
        return self::get(self::APP_NAME);
    }

    /**
     * Get configurations/single item from config
     * @param string|null $key
     * @return array|string
     */
    public static function get(?string $key = null)
    {
        if (isset($key)) {
            return self::$configurations[$key];
        }

        return self::$configurations;
    }

    /**
     * Set configuration
     * @param string $key
     * @param mixed $value
     */
    public static function set(string $key, $value): void
    {
        self::$configurations[$key] = $value;
    }
}