<?php

namespace Laptop\ComplexNumber\Action;

use Laptop\ComplexNumber\Entity;
use Laptop\RealNumber\Action\AddInterface;
use Laptop\RealNumber\Action\MulInterface;
use Laptop\RealNumber\Action\SubInterface;

final class Mul extends ActionAbstract
{
    /**
     * @var AddInterface
     */
    private $addAction;

    /**
     * @var SubInterface
     */
    private $subAction;

    /**
     * @var MulInterface
     */
    private $mulAction;

    public function __construct(AddInterface $addAction, SubInterface $subAction, MulInterface $mulAction)
    {
        $this->addAction = $addAction;
        $this->subAction = $subAction;
        $this->mulAction = $mulAction;
    }

    protected function computeRealNumber(Entity $leftNumber, Entity $rightNumber, ?int $precision = 0): float
    {
        return $this->subAction
            ->execute(
                $this->mulAction->execute($leftNumber->getRealNumber(), $rightNumber->getRealNumber(), $precision),
                $this->mulAction->execute($leftNumber->getImaginaryNumber(), $rightNumber->getImaginaryNumber(), $precision),
                $precision
            );
    }

    protected function computeImaginaryNumber(Entity $leftNumber, Entity $rightNumber, ?int $precision = 0): float
    {
        return $this->addAction
            ->execute(
                $this->mulAction->execute($leftNumber->getRealNumber(), $rightNumber->getImaginaryNumber(), $precision),
                $this->mulAction->execute($leftNumber->getImaginaryNumber(), $rightNumber->getRealNumber(), $precision),
                $precision
            );
    }
}