<?php

namespace Laptop\ComplexNumber\Action;

use Laptop\ComplexNumber\Entity;

interface ActionInterface
{
    public function execute(Entity $leftNumber, Entity $rightNumber, ?int $precision = 0): Entity;
}