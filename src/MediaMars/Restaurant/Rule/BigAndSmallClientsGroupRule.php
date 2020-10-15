<?php

namespace MediaMars\Restaurant\Rule;

use MediaMars\Restaurant\Data\Table;
use MediaMars\Restaurant\DataStructure\ClientGroupQueueInterface;
use MediaMars\Restaurant\DataStructure\TableListInterface;
use MediaMars\Restaurant\Rule\Service\ClientsGroupQueueService;

class BigAndSmallClientsGroupRule extends AbstractTableRule
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
        while ($minSizeGroup = $this->clientsGroupQueueService->getLessSizeGroupAfterGroup($groupQueue, $minSizeGroup)) {
            foreach ($tables as $table) {
                /** @var Table $table */
                $clientsGroupRelation = $table->getClientsGroupRelation();
                if ($clientsGroupRelation->isEmpty() && $table->size() >= $minSizeGroup->size()) {

                    $this->addGroupToTableFromQueue($table, $minSizeGroup, $groupQueue);
                    return false;
                }
            }
        }

        return true;
    }
}