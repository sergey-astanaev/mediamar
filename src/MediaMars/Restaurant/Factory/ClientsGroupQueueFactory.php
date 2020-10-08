<?php

namespace MediaMars\Restaurant\Factory;

use MediaMars\Restaurant\DataStructure\ClientsGroupQueue;
use MediaMars\Restaurant\Service\ArrayOperation;

class ClientsGroupQueueFactory implements ClientGroupQueueFactoryInterface
{
    /**
     * @var ArrayOperation
     */
    private $arrayOperation;

    /**
     * @param ArrayOperation $arrayOperation
     */
    public function __construct(ArrayOperation $arrayOperation)
    {
        $this->arrayOperation = $arrayOperation;
    }

    /**
     * {@inheritdoc}
     */
    public function create()
    {
        return new ClientsGroupQueue($this->arrayOperation);
    }
}