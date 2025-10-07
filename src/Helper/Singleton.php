<?php

declare(strict_types=1);

namespace Raketa\BackendTestTask\Helper;

class Singleton
{
    private static $instances = [];

    protected function __construct() {}
    protected function __clone() {}
    public function __wakeup() {}

    public static function getInstance(): static
    {
        $subclass = static::class;
        if (!isset(self::$instances[$subclass])) {
            self::$instances[$subclass] = new static();
        }
        return self::$instances[$subclass];
    }
}
