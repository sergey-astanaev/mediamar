<?php

namespace Laptop\RealNumber\Action\Bc;

use Laptop\RealNumber\Action\DivInterface;

final class Div implements DivInterface
{
    /**
     * @param float $leftNumber
     * @param float $rightNumber
     * @param int|null $precision
     *
     * @return float
     *
     * @throws \DivisionByZeroError
     */
    public function execute(float $leftNumber, float $rightNumber, ?int $precision = 0): float
    {
        if (bccomp(0, $rightNumber, $precision) === 0) {
            throw new \DivisionByZeroError('Division by zero');
        }

        return (float)bcdiv($leftNumber, $rightNumber, $precision);
    }
}