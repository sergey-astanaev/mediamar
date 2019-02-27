<?php

namespace MediaMars\Restaurant\Factory;

use MediaMars\Restaurant\Data\Table;
use MediaMars\Restaurant\Data\TableClientsGroupRelation;
use MediaMars\Restaurant\Service\ArrayOperation;

class ClientsGroupRelationFactory implements ClientsGroupRelationInterfaceFactory
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
    public function create(Table $table)
    {
        return new TableClientsGroupRelation($table, $this->arrayOperation);
    }
}