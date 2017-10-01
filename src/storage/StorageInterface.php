<?php

namespace app\storage;


interface StorageInterface
{
    /**
     * @param string $key
     * @return bool
     */
    public function has(string $key): bool;

    /**
     * @param $key
     * @param $value
     * @param $ttl
     * @return mixed
     */
    public function set(string $key, string $value, ?int $ttl = null);

    /**
     * @param $key
     * @return mixed
     */
    public function get(string $key);
}