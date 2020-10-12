<?php

namespace ComplexNumberTest;

use Laptop\ComplexNumber\Action\ActionInterface;
use Laptop\ComplexNumber\Action\Sub;
use Laptop\ComplexNumber\Entity;
use Laptop\RealNumber\Action\SubInterface;

class SubTest extends ActionAbstract
{
    protected function getAction(
        Entity $leftNumber,
        Entity $rightNumber,
        float $expectedRealNumber,
        float $expectedImaginaryNumber,
        int $precision
    ): ActionInterface {
        return new Sub(
            $this->getRealNumberAction(
                SubInterface::class,
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