<?php

namespace Laptop\RealNumber\Action;

interface ActionInterface
{
    public function execute(float $leftNumber, float $rightNumber, ?int $precision = 0): float;
}