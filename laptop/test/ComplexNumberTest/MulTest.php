<?php

namespace ComplexNumberTest;

use Laptop\ComplexNumber\Action\ActionInterface;
use Laptop\ComplexNumber\Action\Mul;
use Laptop\ComplexNumber\Entity;
use Laptop\RealNumber\Action\AddInterface;
use Laptop\RealNumber\Action\MulInterface;
use Laptop\RealNumber\Action\SubInterface;


class MulTest extends ActionAbstract
{
    private const RETURN_VALUE_OF_FIRST_REAL_MUL = 1.111;
    private const RETURN_VALUE_OF_SECOND_REAL_MUL = 2.222;

    private const RETURN_VALUE_OF_FIRST_IMAGINARY_MUL = 3.333;
    private const RETURN_VALUE_OF_SECOND_IMAGINARY_MUL = 4.444;

    protected function getAction(
        Entity $leftNumber,
        Entity $rightNumber,
        float $expectedRealNumber,
        float $expectedImaginaryNumber,
        int $precision
    ): ActionInterface {
        return new Mul(
            $this->getRealNumberAction(
                AddInterface::class,
                [
                    $this->createDataItem(
                        self::RETURN_VALUE_OF_FIRST_IMAGINARY_MUL,
                        self::RETURN_VALUE_OF_SECOND_IMAGINARY_MUL,
                        $precision,
                        $expectedImaginaryNumber
                    )
                ]
            ),
            $this->getRealNumberAction(
                SubInterface::class,
                [
                    $this->createDataItem(
                        self::RETURN_VALUE_OF_FIRST_REAL_MUL,
                        self::RETURN_VALUE_OF_SECOND_REAL_MUL,
                        $precision,
                        $expectedRealNumber
                    )
                ]
            ),
            $this->getRealNumberAction(
                MulInterface::class,
                [
                    $this->createDataItem(
                        $leftNumber->getRealNumber(),
                        $rightNumber->getRealNumber(),
                        $precision,
                        self::RETURN_VALUE_OF_FIRST_REAL_MUL
                    ),
                    $this->createDataItem(
                        $leftNumber->getImaginaryNumber(),
                        $rightNumber->getImaginaryNumber(),
                        $precision,
                        self::RETURN_VALUE_OF_SECOND_REAL_MUL
                    ),
                    $this->createDataItem(
                        $leftNumber->getRealNumber(),
                        $rightNumber->getImaginaryNumber(),
                        $precision,
                        self::RETURN_VALUE_OF_FIRST_IMAGINARY_MUL
                    ),
                    $this->createDataItem(
                        $leftNumber->getImaginaryNumber(),
                        $rightNumber->getRealNumber(),
                        $precision,
                        self::RETURN_VALUE_OF_SECOND_IMAGINARY_MUL
                    ),
                ]
            )
        );
    }
}