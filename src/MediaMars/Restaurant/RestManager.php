<?php

namespace MediaMars\Restaurant;

use MediaMars\Restaurant\Data\ClientsGroup;
use MediaMars\Restaurant\Data\Table;
use MediaMars\Restaurant\DataStructure\ClientGroupQueueInterface;
use MediaMars\Restaurant\DataStructure\TableListInterface;
use MediaMars\Restaurant\Factory\ClientGroupQueueFactoryInterface;
use MediaMars\Restaurant\Rule\RuleInterface;

class RestManager
{
    /**
     * @var TableListInterface
     */
    private $tables;

    /**
     * @var RuleInterface
     */
    private $rule;

    /**
     * @var ClientGroupQueueInterface
     */
    private $clientGroupQueue;

    /**
     * RestManager constructor.
     * @param TableListInterface $tables
     * @param RuleInterface $rule
     * @param ClientGroupQueueFactoryInterface $clientGroupQueueFactory
     */
    public function __construct(TableListInterface $tables, RuleInterface $rule, ClientGroupQueueFactoryInterface $clientGroupQueueFactory)
    {
        $this->tables = $tables;
        $this->rule = $rule;
        $this->clientGroupQueue = $clientGroupQueueFactory->create();
    }

    /**
     * new client(s) show up
     *
     * @param ClientsGroup $group
     */
    public function onArrive(ClientsGroup $group)
    {
        $this->clientGroupQueue->add($group);
        $this->rule->apply($this->tables, $this->clientGroupQueue);
    }

    /**
     * client(s) leave, either served or simply abandoning the queue
     *
     * @param ClientsGroup $group
     */
    public function onLeave(ClientsGroup $group)
    {
        $this->clientGroupQueue->remove($group);
        $table = $this->lookup($group);
        if ($table !== null) {
            $table->getClientsGroupRelation()->remove($group);
            $this->rule->apply($this->tables, $this->clientGroupQueue);
        }
    }

    /**
     * return table where a given client group is seated,
     * or null if it is still queuing or has already left
     *
     * @param ClientsGroup $group
     * @return Table|null
     */
    public function lookup(ClientsGroup $group)
    {
        foreach ($this->tables as $table) {
            /** @var Table $table */
            $clientsGroupRelation = $table->getClientsGroupRelation();
            if (!$clientsGroupRelation->isEmpty() && $clientsGroupRelation->contains($group)) {
                return $table;
            }
        }
    }
}