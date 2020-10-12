<?php

namespace Laptop\ComplexNumber\Action;

use Laptop\ComplexNumber\Entity;

abstract class ActionAbstract implements ActionInterface
{
    public function execute(Entity $leftNumber, Entity $rightNumber, ?int $precision = 0): Entity
    {
        return new Entity(
                $this->computeRealNumber($leftNumber, $rightNumber, $precision),
                $this->computeImaginaryNumber($leftNumber, $rightNumber, $precision)
            );
    }

    abstract protected function computeRealNumber(Entity $leftNumber, Entity $rightNumber, ?int $precision = 0): float;

    abstract protected function computeImaginaryNumber(Entity $leftNumber, Entity $rightNumber, ?int $precision = 0): float;
}