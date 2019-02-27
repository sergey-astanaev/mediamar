<?php

namespace MediaMars\Restaurant\Rule;

use MediaMars\Restaurant\Data\ClientsGroup;
use MediaMars\Restaurant\Data\Table;
use MediaMars\Restaurant\DataStructure\ClientGroupQueueInterface;
use MediaMars\Restaurant\DataStructure\TableListInterface;
use MediaMars\Restaurant\Rule\Service\ClientsGroupQueueService;

class ShareEmptyChairsForSmallClientsGroupRule extends AbstractTableRule
{
    /**
     * @var ClientsGroupQueueService
     */
    private $searchMinGroupSize;

    public function __construct(ClientsGroupQueueService $searchMinGroupSize, RuleInterface $nextRule = null)
    {
        $this->searchMinGroupSize = $searchMinGroupSize;

        parent::__construct($nextRule);
    }

    /**
     * {@inheritdoc}
     */
    protected function subApply(TableListInterface $tables, ClientGroupQueueInterface $groupQueue)
    {
        $minSizeGroup = $groupQueue->get();
        do {
            foreach ($tables as $table) {
                /** @var Table $table */
                $clientsGroupRelation = $table->getClientsGroupRelation();
                if (!$clientsGroupRelation->isEmpty()) {
                    $emptyChairOfTable = $this->getEmptyChairOfTable($table, $minSizeGroup);
                    if ($emptyChairOfTable > 0 && $emptyChairOfTable >= $minSizeGroup->size()) {
                        $clientsGroupRelation->add($minSizeGroup);
                        $groupQueue->remove($minSizeGroup);
                        return false;
                    }
                }
            }

        } while ($minSizeGroup = $this->searchMinGroupSize->getLessSizeGroupAfterGroup($groupQueue, $minSizeGroup));

        return true;
    }

    private function getEmptyChairOfTable(Table $table, ClientsGroup $group)
    {
        $tableSize = $table->size();
        $sumGroupSize = $table->getClientsGroupRelation()->size();

        return $tableSize - $sumGroupSize;
    }
}