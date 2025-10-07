<?php

declare(strict_types=1);

namespace Raketa\BackendTestTask\Infrastructure\Exception;

use Exception;
use Throwable;

class RedisConnectorException extends Exception
{
    public function __construct($message, $code = 0, ?Throwable $previous = null)
    {
        parent::__construct($message, $code, $previous);
    }

    public function __toString(): string
    {
        return sprintf(
            "[%s] %s in %s on line %d \n %s",
            $this->getCode(),
            $this->getMessage(),
            $this->getFile(),
            $this->getLine(),
            $this->getTraceAsString()
        );
    }
}
