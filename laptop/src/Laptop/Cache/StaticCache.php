<?php

namespace Laptop\Cache;

class StaticCache implements CacheInterface
{
    /**
     * @var array
     */
    private static $data = [];

    /**
     * @inheritDoc
     */
    public function setValue(string $key, $value, ?int $ttl = null): void
    {
        self::$data[$key] = $value;
    }

    /**
     * @inheritDoc
     */
    public function getValue(string $key, $default = null)
    {
        return $this->has($key) ? self::$data[$key] : $default;
    }

    public function delete(string $key)
    {
        if ($this->has($key)) {
            unset(self::$data[$key]);
        }
    }

    public function has(string $key): bool
    {
        return isset(self::$data[$key]) || self::$data[$key] === null;
    }
}