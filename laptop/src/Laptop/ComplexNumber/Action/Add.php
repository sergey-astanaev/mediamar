<?php

namespace Laptop\ComplexNumber\Action;

use Laptop\ComplexNumber\Entity;
use Laptop\RealNumber\Action\AddInterface;

final class Add extends ActionAbstract
{
    /**
     * @var AddInterface
     */
    private $addAction;

    public function __construct(AddInterface $addAction)
    {
        $this->addAction = $addAction;
    }

    protected function computeRealNumber(Entity $leftNumber, Entity $rightNumber, ?int $precision = 0): float
    {
        return $this->addAction->execute($leftNumber->getRealNumber(), $rightNumber->getRealNumber(), $precision);
    }

    protected function computeImaginaryNumber(Entity $leftNumber, Entity $rightNumber, ?int $precision = 0): float
    {
        return $this->addAction->execute($leftNumber->getImaginaryNumber(), $rightNumber->getImaginaryNumber(), $precision);
    }
}