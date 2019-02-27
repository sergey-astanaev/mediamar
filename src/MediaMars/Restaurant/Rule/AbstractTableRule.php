<?php

namespace MediaMars\Restaurant\Rule;

use MediaMars\Restaurant\DataStructure\ClientGroupQueueInterface;
use MediaMars\Restaurant\DataStructure\TableListInterface;

abstract class AbstractTableRule  implements RuleInterface
{
    /**
     * @var RuleInterface|null
     */
    private $nextRule;

    public function __construct(RuleInterface $nextRule = null)
    {
        $this->nextRule = $nextRule;
    }

    /**
     * @param TableListInterface $tables
     * @param ClientGroupQueueInterface $groupQueue
     */
    public function apply(TableListInterface $tables, ClientGroupQueueInterface $groupQueue)
    {
        $doNext = $this->subApply($tables, $groupQueue);

        if ($this->nextRule !== null && $doNext === true) {
            $this->nextRule->apply($tables, $groupQueue);
        }
    }

    /**
     * @param TableListInterface $tables
     * @param ClientGroupQueueInterface $groupQueue
     * @return bool
     */
    abstract protected function subApply(TableListInterface $tables, ClientGroupQueueInterface $groupQueue);
}