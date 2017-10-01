<?php

namespace app\storage;


class RedisStorage implements StorageInterface
{
    /** @var  \Redis */
    protected $redis;

    /**
     * RedisStorage constructor.
     * @param \Redis $redis
     */
    public function __construct(\Redis $redis)
    {
        $this->redis = $redis;
    }

    public function has(string $key): bool
    {
        return $this->redis->exists($key);
    }

    public function set(string $key, string $value,  ?int $ttl = null)
    {
        if (null === $ttl) {
            $this->redis->set($key, $value);
        } else {
            $this->redis->setex($key, $ttl, $value);
        }
    }

    public function get(string $key)
    {
        return $this->redis->get($key);
    }
}