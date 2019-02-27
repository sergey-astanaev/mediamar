<?php

namespace MediaMars\Restaurant\DataStructure;

use MediaMars\Restaurant\Data\ClientsGroup;
use MediaMars\Restaurant\Service\ArrayOperation;

class ClientsGroupQueue implements ClientGroupQueueInterface
{
    /**
     * @var ClientsGroup[]
     */
    private $queue = [];

    /**
     * @var int|null
     */
    private $position;

    /**
     * @var ArrayOperation
     */
    private $arrayOperation;

    public function __construct(ArrayOperation $arrayOperation)
    {
        $this->arrayOperation = $arrayOperation;
    }

    /**
     * {@inheritdoc}
     */
    public function add(ClientsGroup $group)
    {
        $this->queue = $this->arrayOperation->addToBegin($group, $this->queue);
    }

    /**
     * {@inheritdoc}
     */
    public function get()
    {
        return $this->queue[$this->initialPosition()];
    }

    /**
     * {@inheritdoc}
     */
    public function remove(ClientsGroup $group)
    {
        $this->queue = $this->arrayOperation->remove($group, $this->queue);
    }

    /**
     * {@inheritdoc}
     */
    public function contains(ClientsGroup $group)
    {
        return $this->arrayOperation->contains($group, $this->queue);
    }

    /**
     * {@inheritdoc}
     */
    public function current()
    {
        return $this->queue[$this->position];
    }

    /**
     * {@inheritdoc}
     */
    public function next()
    {
        return $this->queue[$this->position--];
    }

    /**
     * {@inheritdoc}
     */
    public function key()
    {
        return $this->position;
    }

    /**
     * {@inheritdoc}
     */
    public function valid()
    {
        return isset($this->queue[$this->position]);
    }

    /**
     * {@inheritdoc}
     */
    public function rewind()
    {
        $this->position = $this->initialPosition();
    }

    /**
     * {@inheritdoc}
     */
    public function count()
    {
        return count($this->queue);
    }

    /**
     * @return int
     */
    private function initialPosition()
    {
        return $this->count() - 1;
    }
}