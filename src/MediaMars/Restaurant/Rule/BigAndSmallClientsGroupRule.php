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
        while ($minSizeGroup = $this->searchMinGroupSize->getLessSizeGroupAfterGroup($groupQueue, $minSizeGroup)) {
            foreach ($tables as $table) {
                /** @var Table $table */
                $clientsGroupRelation = $table->getClientsGroupRelation();
                if ($clientsGroupRelation->isEmpty() && $table->size() >= $minSizeGroup->size()) {
                    $clientsGroupRelation->add($minSizeGroup);
                    $groupQueue->remove($minSizeGroup);
                    return false;
                }
            }
        }

        return true;
    }
}