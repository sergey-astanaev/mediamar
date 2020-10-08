<?php

namespace MediaMars\Restaurant\Rule;


use MediaMars\Restaurant\DataStructure\ClientGroupQueueInterface;
use MediaMars\Restaurant\DataStructure\TableListInterface;

interface RuleInterface
{
    /**
     * @param TableListInterface $tables
     * @param ClientGroupQueueInterface $groupQueue
     */
    public function apply(TableListInterface $tables, ClientGroupQueueInterface $groupQueue);
}