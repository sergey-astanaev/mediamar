<?php

namespace MediaMars\Restaurant\Data;

use MediaMars\Restaurant\Service\ArrayOperation;

class TableClientsGroupRelation implements TableClientsGroupRelationInterface
{
    /**
     * @var Table
     */
    private $table;

    /**
     * @var ArrayOperation
     */
    private $arrayOperation;

    private $clientsGroups = [];

    public function __construct(Table $table, ArrayOperation $arrayOperation)
    {
        $this->table = $table;
        $this->arrayOperation = $arrayOperation;
    }

    /**
     * @param ClientsGroup $group
     */
    public function add(ClientsGroup $group)
    {
        $this->clientsGroups = $this->arrayOperation->addToEnd($group, $this->clientsGroups);
    }

    /**
     * @param ClientsGroup $group
     */
    public function remove(ClientsGroup $group)
    {
        $this->clientsGroups = $this->arrayOperation->remove($group, $this->clientsGroups);
    }

    /**
     * @param ClientsGroup $group
     * @return bool
     */
    public function contains(ClientsGroup $group)
    {
        return $this->arrayOperation->contains($group, $this->clientsGroups);
    }

    /**
     * @return bool
     */
    public function isEmpty()
    {
        return $this->arrayOperation->isEmpty($this->clientsGroups);
    }

    /**
     * @return int
     */
    public function size()
    {
        return array_reduce(
            $this->clientsGroups,
            function (int $sum, ClientsGroup $group) {
                return $sum + $group->size();
            },
            0
        );
    }
}