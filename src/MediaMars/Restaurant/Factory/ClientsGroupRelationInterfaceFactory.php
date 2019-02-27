<?php

namespace MediaMars\Restaurant\Factory;

use MediaMars\Restaurant\Data\Table;
use MediaMars\Restaurant\Data\TableClientsGroupRelationInterface;

interface ClientsGroupRelationInterfaceFactory
{
    /**
     * @param Table $table
     * @return TableClientsGroupRelationInterface
     */
    public function create(Table $table);
}