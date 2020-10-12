<?php

namespace Laptop\RealNumber\Action\Bc;

use Laptop\RealNumber\Action\MulInterface;

final class Mul implements MulInterface
{
    public function execute(float $leftNumber, float $rightNumber, ?int $precision = 0): float
    {
        return (float)bcmul($leftNumber, $rightNumber, $precision);
    }
}