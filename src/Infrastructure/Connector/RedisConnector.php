<?php

declare(strict_types = 1);

namespace Raketa\BackendTestTask\Infrastructure\Connector;

use Raketa\BackendTestTask\Domain\Cart;
use Raketa\BackendTestTask\Infrastructure\ConnectorException;
use Redis;
use RedisException;

class RedisConnector
{
    private Redis $redis;

    public function __construct($redis)
    {
        $this->redis = $redis;
    }

    /**
     * @throws ConnectorException
     */
    public function get($key)
    {
        try {
            return unserialize($this->redis->get($key));
        } catch (RedisException $e) {
            throw new ConnectorException('Connector error', $e->getCode(), $e);
        }
    }

    /**
     * @throws ConnectorException
     */
    public function set(string $key, $value)
    {
        try {
            $this->redis->setex($key, 24 * 60 * 60, serialize($value));
        } catch (RedisException $e) {
            throw new ConnectorException('Connector error', $e->getCode(), $e);
        }
    }

    public function has($key): bool
    {
        return $this->redis->exists($key);
    }
}
