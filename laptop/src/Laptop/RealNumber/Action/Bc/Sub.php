<?php

namespace Laptop\RealNumber\Action\Bc;

use Laptop\RealNumber\Action\SubInterface;

final class Sub implements SubInterface
{
    public function execute(float $leftNumber, float $rightNumber, ?int $precision = 0): float
    {
        return (float)bcsub($leftNumber, $rightNumber, $precision);
    }
}