<?php

namespace Laptop\ComplexNumber\Action;

use Laptop\ComplexNumber\Entity;
use Laptop\RealNumber\Action\AddInterface;
use Laptop\RealNumber\Action\DivInterface;
use Laptop\RealNumber\Action\MulInterface;
use Laptop\RealNumber\Action\SubInterface;

final class Div extends ActionAbstract
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

    /**
     * @var DivInterface
     */
    private $divAction;

    public function __construct(
        AddInterface $addAction,
        SubInterface $subAction,
        MulInterface $mulAction,
        DivInterface $divAction
    ){
        $this->addAction = $addAction;
        $this->subAction = $subAction;
        $this->mulAction = $mulAction;
        $this->divAction = $divAction;
    }

    protected function computeRealNumber(Entity $leftNumber, Entity $rightNumber, ?int $precision = 0): float
    {
        $addNumber = $this->addAction
            ->execute(
                $this->mulAction->execute($leftNumber->getRealNumber(), $rightNumber->getRealNumber(), $precision),
                $this->mulAction->execute($leftNumber->getImaginaryNumber(), $rightNumber->getImaginaryNumber(), $precision),
                $precision
            );

        $sumOfSquare = $this->sumOfSquare($rightNumber->getRealNumber(), $rightNumber->getImaginaryNumber(), $precision);

        return $this->divAction->execute(
            $addNumber,
            $sumOfSquare,
            $precision
        );
    }

    protected function computeImaginaryNumber(Entity $leftNumber, Entity $rightNumber, ?int $precision = 0): float
    {
        $subNumber = $this->subAction
            ->execute(
                $this->mulAction->execute($rightNumber->getRealNumber(), $leftNumber->getImaginaryNumber(), $precision),
                $this->mulAction->execute($leftNumber->getRealNumber(), $rightNumber->getImaginaryNumber(), $precision),
                $precision
            );

        $sumOfSquare = $this->sumOfSquare($rightNumber->getRealNumber(), $rightNumber->getImaginaryNumber(), $precision);

        return $this->divAction->execute(
            $subNumber,
            $sumOfSquare,
            $precision
        );
    }

    private function sumOfSquare(float $leftNumber, float $rightNumber, int $precision): float
    {
        return $this->addAction->execute(
            $this->mulAction->execute($leftNumber, $leftNumber, $precision),
            $this->mulAction->execute($rightNumber, $rightNumber, $precision),
            $precision
        );
    }
}