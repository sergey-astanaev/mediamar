<?php

namespace Laptop\RealNumber\Action\Cached;

use Laptop\Cache\CacheInterface;
use Laptop\RealNumber\Action\AddInterface;
use Laptop\RealNumber\Action\DivInterface;
use Laptop\RealNumber\Action\SubInterface;

class Div extends ActionAbstract implements AddInterface
{
    public function __construct(DivInterface $divAction, CacheInterface $cache)
    {
        parent::__construct($divAction, $cache);
    }
}