<?php

namespace Laptop\ComplexNumber\Action;

use Laptop\ComplexNumber\Entity;
use Laptop\RealNumber\Action\SubInterface;

final class Sub extends ActionAbstract
{
    /**
     * @var SubInterface
     */
    private $subAction;

    public function __construct(SubInterface $subAction)
    {
        $this->subAction = $subAction;
    }

    protected function computeRealNumber(Entity $leftNumber, Entity $rightNumber, ?int $precision = 0): float
    {
        return $this->subAction->execute($leftNumber->getRealNumber(), $rightNumber->getRealNumber(), $precision);
    }

    protected function computeImaginaryNumber(Entity $leftNumber, Entity $rightNumber, ?int $precision = 0): float
    {
        return $this->subAction->execute($leftNumber->getImaginaryNumber(), $rightNumber->getImaginaryNumber(), $precision);
    }
}