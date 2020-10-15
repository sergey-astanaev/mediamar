<?php

namespace MediaMars\Restaurant\Rule;

use MediaMars\Restaurant\Data\Table;
use MediaMars\Restaurant\DataStructure\ClientGroupQueueInterface;
use MediaMars\Restaurant\DataStructure\TableListInterface;
use MediaMars\Restaurant\Rule\Service\ClientsGroupQueueService;

class ShareEmptyChairsForSmallClientsGroupRule extends AbstractTableRule
{
    /**
     * @var ClientsGroupQueueService
     */
    private $clientsGroupQueueService;

    public function __construct(ClientsGroupQueueService $clientsGroupQueueService, RuleInterface $nextRule = null)
    {
        $this->clientsGroupQueueService = $clientsGroupQueueService;

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
                    $emptyChairOfTable = $this->getEmptyChairOfTable($table);
                    if ($emptyChairOfTable > 0 && $emptyChairOfTable >= $minSizeGroup->size()) {
                        $this->addGroupToTableFromQueue($table, $minSizeGroup, $groupQueue);

                        return false;
                    }
                }
            }

        } while ($minSizeGroup = $this->clientsGroupQueueService->getLessSizeGroupAfterGroup($groupQueue, $minSizeGroup));

        return true;
    }

    /**
     * @param Table $table
     * @return int
     */
    private function getEmptyChairOfTable(Table $table)
    {
        $tableSize = $table->size();
        $sumGroupSize = $table->getClientsGroupRelation()->size();

        return $tableSize - $sumGroupSize;
    }
}