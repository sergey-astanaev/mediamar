<?php

namespace Laptop\RealNumber\Action\Cached;

use Laptop\Cache\CacheInterface;
use Laptop\RealNumber\Action\AddInterface;
use Laptop\RealNumber\Action\SubInterface;

class Sub extends ActionAbstract implements AddInterface
{
    public function __construct(SubInterface $subAction, CacheInterface $cache)
    {
        parent::__construct($subAction, $cache);
    }
}