<?php

namespace Laptop\RealNumber\Action\Cached;

use Laptop\Cache\CacheInterface;
use Laptop\RealNumber\Action\AddInterface;

class Add extends ActionAbstract implements AddInterface
{
    public function __construct(AddInterface $addAction, CacheInterface $cache)
    {
        parent::__construct($addAction, $cache);
    }
}