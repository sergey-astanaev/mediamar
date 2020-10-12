<?php

namespace ComplexNumberTest;

use Laptop\ComplexNumber\Action\ActionInterface;
use Laptop\ComplexNumber\Action\Add;
use Laptop\ComplexNumber\Entity;
use Laptop\RealNumber\Action\AddInterface;

class AddTest extends ActionAbstract
{
    protected function getAction(
        Entity $leftNumber,
        Entity $rightNumber,
        float $expectedRealNumber,
        float $expectedImaginaryNumber,
        int $precision
    ): ActionInterface {
        return new Add(
            $this->getRealNumberAction(
                AddInterface::class,
                [
                    $this->createDataItem(
                        $leftNumber->getRealNumber(),
                        $rightNumber->getRealNumber(),
                        $precision,
                        $expectedRealNumber
                    ),
                    $this->createDataItem(
                        $leftNumber->getImaginaryNumber(),
                        $rightNumber->getImaginaryNumber(),
                        $precision,
                        $expectedImaginaryNumber
                    )
                ]
            )
        );
    }
}