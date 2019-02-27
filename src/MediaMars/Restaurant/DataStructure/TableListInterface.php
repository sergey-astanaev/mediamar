<?php

namespace MediaMars\Restaurant\DataStructure;

use MediaMars\Restaurant\Data\Table;

interface TableListInterface extends \Iterator, \Countable
{
    /**
     * @param Table $table
     */
    public function add(Table $table);

    /**
     * @param Table $table
     */
    public function remove(Table $table);

    /**
     * @param Table $table
     * @return bool
     */
    public function contains(Table $table);
}