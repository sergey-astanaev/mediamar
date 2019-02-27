<?php

namespace MediaMars\Restaurant\DataStructure;

use MediaMars\Restaurant\Data\ClientsGroup;

interface ClientGroupQueueInterface extends \Iterator, \Countable
{
    /**
     * @param ClientsGroup $group
     */
    public function add(ClientsGroup $group);

    /**
     * @return ClientsGroup|null
     */
    public function get();

    /**
     * @param ClientsGroup $group
     */
    public function remove(ClientsGroup $group);

    /**
     * @param ClientsGroup $group
     * @return bool
     */
    public function contains(ClientsGroup $group);
}