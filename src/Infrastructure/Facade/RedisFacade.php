<?php

declare(strict_types=1);

namespace Raketa\BackendTestTask\Infrastructure\Facade;

use Raketa\BackendTestTask\Infrastructure\Connector\RedisConnector;
use Raketa\BackendTestTask\Infrastructure\Exception\RedisConnectorException;
use Redis;
use RedisException;


class  RedisFacade
{
    private string $host = 'redis';
    private int $port = 6379;
    private ?string $password = null;
    private ?int $dbindex = null;

    protected $connector;

    public function __construct()
    {
        // $this->host = $_ENV['REDIS_HOST'];
        // $this->port = $_ENV['REDIS_PORT'];
        // $this->password = $_ENV['REDIS_PASSWORD'];
        // $this->dbindex = $_ENV['REDIS_DBINDEX'];

        $this->connector = RedisConnector::getInstance();
    }
    protected function connect()
    {
        try {
            if (! $this->connector->isConnected()) {
                $this->connector->connect($this->host, $this->port);
                if (!empty($this->password)) {
                    $this->connector->auth($this->password);
                }
                if (! empty($this->dbindex)) {
                    $this->connector->select($this->dbindex);
                }
            }
            $this->connector->checkConnection();
        } catch (RedisException $e) {
            throw new RedisConnectorException('RedisConnector connect error:' . $e->getMessage(), $e->getCode(), $e);
        }
    }

    public function set(string $key, $value, $ex = null)
    {
        $this->connect();
        try {
            $this->connector->set($key, $value, $ex);
        } catch (RedisException $e) {
            throw new RedisConnectorException('RedisConnector set error: ' . $e->getMessage(), $e->getCode(), $e);
        }
    }

    public function get($key)
    {
        $this->connect();
        try {
            if ($this->connector->has($key)) {
                return $this->connector->get($key);
            }
        } catch (RedisException $e) {
            throw new RedisConnectorException('RedisConnector get error: ' . $e->getMessage(), $e->getCode(), $e);
        }
        return null;
    }
}
