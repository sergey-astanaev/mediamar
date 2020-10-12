<?php

namespace Laptop\RealNumber\Action\Cached;

use Laptop\Cache\CacheInterface;
use Laptop\RealNumber\Action\ActionInterface;

class ActionAbstract
{
    private $action;
    private $cache;

    public function __construct(ActionInterface $action, CacheInterface $cache)
    {
        $this->action = $action;
        $this->cache = $cache;
    }

    public function execute(float $leftNumber, float $rightNumber, ?int $precision = 0): float
    {
        $key = $this->getKey($leftNumber, $rightNumber, $precision);
        $value = $this->cache->getValue($key);
        if ($value === null) {
            $value = $this->action->execute($leftNumber, $rightNumber, $precision);
            $this->cache->setValue($key, $value);
        }

        return $value;
    }

    private function getKey(float $leftNumber, float $rightNumber, int $precision): string
    {
        return static::class . $leftNumber . $rightNumber . $precision;
    }
}