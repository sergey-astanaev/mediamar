<?php

namespace MediaMars\Restaurant\Data;

use MediaMars\Restaurant\Factory\ClientsGroupRelationInterfaceFactory;

class Table
{
    /**
     * @var int
     */
    private $size;

    private $clientsGroupRelation;

    /**
     * Table constructor.
     * @param $size
     * @param ClientsGroupRelationInterfaceFactory $clientsGroupRelationFactory
     */
    public function __construct($size, ClientsGroupRelationInterfaceFactory $clientsGroupRelationFactory)
    {
        $this->size = $size;
        $this->clientsGroupRelation = $clientsGroupRelationFactory->create($this);
    }

    /**
     * @return int
     */
    public final function size()
    {
        return $this->size;
    }

    /**
     * @return TableClientsGroupRelationInterface
     */
    public function getClientsGroupRelation()
    {
        return $this->clientsGroupRelation;
    }
}