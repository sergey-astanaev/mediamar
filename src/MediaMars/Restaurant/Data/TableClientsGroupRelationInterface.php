<?php

namespace MediaMars\Restaurant\Data;

interface TableClientsGroupRelationInterface
{
    /**
     * @param ClientsGroup $group
     */
    public function add(ClientsGroup $group);

    /**
     * @param ClientsGroup $group
     */
    public function remove(ClientsGroup $group);

    /**
     * @param ClientsGroup $group
     * @return bool
     */
    public function contains(ClientsGroup $group);

    /**
     * @return bool
     */
    public function isEmpty();

    /**
     * @return int
     */
    public function size();
}