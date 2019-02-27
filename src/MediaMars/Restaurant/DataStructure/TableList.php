<?php

namespace MediaMars\Restaurant\DataStructure;

use MediaMars\Restaurant\Data\Table;
use MediaMars\Restaurant\Service\ArrayOperation;

class TableList implements TableListInterface
{
    /**
     * @var array
     */
    private $tables = [];

    /**
     * @var int|null;
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
     * @param Table $table
     */
    public function add(Table $table)
    {
        $this->tables = $this->arrayOperation->addToEnd($table, $this->tables);
    }

    /**
     * @param Table $table
     */
    public function remove(Table $table)
    {
        $this->tables = $this->arrayOperation->remove($table, $this->tables);
    }

    /**
     * @param Table $table
     * @return bool
     */
    public function contains(Table $table)
    {
        return $this->arrayOperation->contains($table, $this->tables);
    }

    /**
     * {@inheritdoc}
     */
    public function current()
    {
        return $this->tables[$this->position];
    }

    /**
     * {@inheritdoc}
     */
    public function next()
    {
        return $this->tables[$this->position++];
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
        return isset($this->tables[$this->position]);
    }

    /**
     * {@inheritdoc}
     */
    public function rewind()
    {
        $this->position = 0;
    }

    /**
     * {@inheritdoc}
     */
    public function count()
    {
        return count($this->tables);
    }
}