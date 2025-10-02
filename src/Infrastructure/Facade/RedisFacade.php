<?php

declare(strict_types = 1);

namespace Raketa\BackendTestTask\Infrastructure\Facade;

use Raketa\BackendTestTask\Infrastructure\Connector\RedisConnector;
use Redis;
use RedisException;


class  RedisFacade
{
    private string $host = 'redis';
    private int $port = 6379;
    private ?string $password = null;
    private ?int $dbindex = null;

    protected $connection;

    public function __construct()
    {
        // $this->host = $_ENV['REDIS_HOST'];
        // $this->port = $_ENV['REDIS_PORT'];
        // $this->password = $_ENV['REDIS_PASSWORD'];
        // $this->dbindex = $_ENV['REDIS_DBINDEX'];
    }

    public function test() {
        $this->build();
    }

    protected function connection () {

    }

    protected function build(): void
    {
        $redis = new Redis();

        try {
            $isConnected = $redis->isConnected();
            if (! $isConnected && $redis->ping('Pong')) {
                $isConnected = $redis->connect(
                    $this->host,
                    $this->port,
                );
            }
        } catch (RedisException $e) {
        }

        if ($isConnected) {
            $redis->auth($this->password);
            $redis->select($this->dbindex);
            $this->connector = new RedisConnector($redis);
        }
    }
}
