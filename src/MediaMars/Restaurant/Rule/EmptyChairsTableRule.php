<?php

namespace MediaMars\Restaurant\Rule;

use MediaMars\Restaurant\Data\Table;
use MediaMars\Restaurant\DataStructure\ClientGroupQueueInterface;
use MediaMars\Restaurant\DataStructure\TableListInterface;

class EmptyChairsTableRule extends AbstractTableRule
{
    /**
     * {@inheritdoc}
     */
    protected function subApply(TableListInterface $tables, ClientGroupQueueInterface $groupQueue)
    {
        $group = $groupQueue->get();
        foreach ($tables as $table) {
            /** @var Table $table */
            $clientsGroupRelation = $table->getClientsGroupRelation();
            if ($clientsGroupRelation->isEmpty() && $table->size() >= $group->size()) {
                $this->addGroupToTableFromQueue($table, $group, $groupQueue);

                return false;
            }
        }

        return true;
    }
}