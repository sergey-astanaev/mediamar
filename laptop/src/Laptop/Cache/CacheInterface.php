<?php

namespace Laptop\Cache;

interface CacheInterface
{
    /**
     * @param string $key
     * @param $value
     * @param int|null $ttl
     *
     * @return void
     */
    public function setValue(string $key, $value, ?int $ttl = null): void;

    /**
     * @param string $key
     * @param $default
     *
     * @return mixed
     */
    public function getValue(string $key, $default = null);

    public function delete(string $key);

    public function has(string $key): bool;
}