<?php

namespace MediaMars\Restaurant\Data;


class ClientsGroup
{
    /**
     * @var int
     */
    private $size;

    /**
     * @param int $size
     */
    public function __construct($size)
    {
        $this->size = $size;
    }

    /**
     * @return int
     */
    public final function size()
    {
        return $this->size;
    }
}