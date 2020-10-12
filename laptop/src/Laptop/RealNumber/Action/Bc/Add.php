<?php

namespace Laptop\RealNumber\Action\Bc;

use Laptop\RealNumber\Action\AddInterface;

final class Add implements AddInterface
{
    public function execute(float $leftNumber, float $rightNumber, ?int $precision = 0): float
    {
        return (float)bcadd($leftNumber, $rightNumber, $precision);
    }
}