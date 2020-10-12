<?php

namespace Laptop\RealNumber\Action\Cached;

use Laptop\Cache\CacheInterface;
use Laptop\RealNumber\Action\MulInterface;

class Mul extends ActionAbstract implements MulInterface
{
    public function __construct(MulInterface $mulAction, CacheInterface $cache)
    {
        parent::__construct($mulAction, $cache);
    }
}