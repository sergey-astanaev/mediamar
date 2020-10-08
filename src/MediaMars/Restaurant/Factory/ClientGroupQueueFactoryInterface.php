<?php

namespace MediaMars\Restaurant\Factory;

use MediaMars\Restaurant\DataStructure\ClientGroupQueueInterface;

interface ClientGroupQueueFactoryInterface
{
    /**
     * @return ClientGroupQueueInterface
     */
    public function create();
}