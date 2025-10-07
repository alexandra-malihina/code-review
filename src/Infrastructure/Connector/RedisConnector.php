<?php

declare(strict_types=1);

namespace Raketa\BackendTestTask\Infrastructure\Connector;

use Raketa\BackendTestTask\Domain\Cart;
use Raketa\BackendTestTask\Helper\Singleton;
use Raketa\BackendTestTask\Infrastructure\Exception\ConnectorException;
use Redis;
use RedisException;

class RedisConnector extends Singleton
{
    private Redis $redis;

    protected function __construct()
    {
        $this->redis = new Redis;
    }

    public function isConnected()
    {
        return $this->redis->isConnected();
    }

    public function connect($host, $port)
    {
        $this->redis->connect($host, $port);
    }

    public function disconnect()
    {
        $this->redis->disconnect();
    }

    public function auth($password)
    {
        $this->redis->auth($password);
    }

    public function select($db)
    {
        $this->redis->select($db);
    }

    public function checkConnection()
    {
        $this->redis->ping();
    }
    public function setConnection($redis)
    {
        $this->redis = $redis;
    }

    public function get($key)
    {
        return unserialize($this->redis->get($key));
    }

    public function set(string $key, $value, ?int $ex = null)
    {
        $data = [
            $key,
            serialize($value)
        ];
        if (!empty($ex)) {
            $data[] = $ex;
        }

        $this->redis->set(...$data);
    }

    public function has($key)
    {
        return $this->redis->exists($key);
    }
}
