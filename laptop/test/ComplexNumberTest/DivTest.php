<?php

namespace ComplexNumberTest;

use Laptop\ComplexNumber\Action\ActionInterface;
use Laptop\ComplexNumber\Action\Div;
use Laptop\ComplexNumber\Entity;
use Laptop\RealNumber\Action\AddInterface;
use Laptop\RealNumber\Action\DivInterface;
use Laptop\RealNumber\Action\MulInterface;
use Laptop\RealNumber\Action\SubInterface;


class DivTest extends ActionAbstract
{
    private const RETURN_VALUE_OF_FIRST_REAL_MUL = 1.111;
    private const RETURN_VALUE_OF_SECOND_REAL_MUL = 1.222;
    private const RETURN_VALUE_OF_REAL_SUM_MUL = 1.333;

    private const RETURN_VALUE_OF_FIRST_IMAGINARY_MUL = 1.444;
    private const RETURN_VALUE_OF_SECOND_IMAGINARY_MUL = 1.555;
    private const RETURN_VALUE_OF_IMAGINARY_SUB_MUL = 1.666;

    private const RETURN_VALUE_OF_RIGHT_REAL_NUMBER_MUL = 1.777;
    private const RETURN_VALUE_OF_RIGHT_IMAGINARY_NUMBER_MUL = 1.888;
    private const RETURN_VALUE_OF_SUM_OF_SQUARE = 1.999;

    /**
     * @expectedException \DivisionByZeroError
     */
    public function testDivByZeroException(): void
    {
        $leftNumber = new Entity(self::LEFT_REAL_NUMBER, self::LEFT_IMAGINARY_NUMBER);
        $rightNumber = new Entity(self::RIGHT_REAL_NUMBER, self::RIGHT_IMAGINARY_NUMBER);

        $action = $this->getDivByZeroExceptionAction(
            $leftNumber,
            $rightNumber,
            self::PRECISION
        );

        $returnValue = $action->execute(
            $leftNumber,
            $rightNumber,
            self::PRECISION
        );
    }

    protected function getAction(
        Entity $leftNumber,
        Entity $rightNumber,
        float $expectedRealNumber,
        float $expectedImaginaryNumber,
        int $precision
    ): ActionInterface {
        $rightRealNumberNumberDataItem = $this->createDataItem(
            $rightNumber->getRealNumber(),
            $rightNumber->getRealNumber(),
            $precision,
            self::RETURN_VALUE_OF_RIGHT_REAL_NUMBER_MUL
        );
        $rightImaginaryNumberNumberDataItem = $this->createDataItem(
            $rightNumber->getImaginaryNumber(),
            $rightNumber->getImaginaryNumber(),
            $precision,
            self::RETURN_VALUE_OF_RIGHT_IMAGINARY_NUMBER_MUL
        );

        $addAction = $this->getRealNumberAction(
            AddInterface::class,
            [
                $this->createDataItem(
                    self::RETURN_VALUE_OF_FIRST_REAL_MUL,
                    self::RETURN_VALUE_OF_SECOND_REAL_MUL,
                    $precision,
                    self::RETURN_VALUE_OF_REAL_SUM_MUL
                ),
                $this->createDataItem(
                    self::RETURN_VALUE_OF_RIGHT_REAL_NUMBER_MUL,
                    self::RETURN_VALUE_OF_RIGHT_IMAGINARY_NUMBER_MUL,
                    $precision,
                    self::RETURN_VALUE_OF_SUM_OF_SQUARE
                ),
                $this->createDataItem(
                    self::RETURN_VALUE_OF_RIGHT_REAL_NUMBER_MUL,
                    self::RETURN_VALUE_OF_RIGHT_IMAGINARY_NUMBER_MUL,
                    $precision,
                    self::RETURN_VALUE_OF_SUM_OF_SQUARE
                )
            ]
        );

        $subAction = $this->getRealNumberAction(
            SubInterface::class,
            [
                $this->createDataItem(
                    self::RETURN_VALUE_OF_FIRST_IMAGINARY_MUL,
                    self::RETURN_VALUE_OF_SECOND_IMAGINARY_MUL,
                    $precision,
                    self::RETURN_VALUE_OF_IMAGINARY_SUB_MUL
                )
            ]
        );

        $mulAction = $this->getRealNumberAction(
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
                $rightRealNumberNumberDataItem,
                $rightImaginaryNumberNumberDataItem,
                $this->createDataItem(
                    $rightNumber->getRealNumber(),
                    $leftNumber->getImaginaryNumber(),
                    $precision,
                    self::RETURN_VALUE_OF_FIRST_IMAGINARY_MUL
                ),
                $this->createDataItem(
                    $leftNumber->getRealNumber(),
                    $rightNumber->getImaginaryNumber(),
                    $precision,
                    self::RETURN_VALUE_OF_SECOND_IMAGINARY_MUL
                ),
                $rightRealNumberNumberDataItem,
                $rightImaginaryNumberNumberDataItem,
            ]
        );

        $divAction = $this->getRealNumberAction(
            DivInterface::class,
            [
                $this->createDataItem(
                    self::RETURN_VALUE_OF_REAL_SUM_MUL,
                    self::RETURN_VALUE_OF_SUM_OF_SQUARE,
                    $precision,
                    $expectedRealNumber
                ),
                $this->createDataItem(
                    self::RETURN_VALUE_OF_IMAGINARY_SUB_MUL,
                    self::RETURN_VALUE_OF_SUM_OF_SQUARE,
                    $precision,
                    $expectedImaginaryNumber
                )
            ]
        );

        return new Div(
            $addAction,
            $subAction,
            $mulAction,
            $divAction
        );
    }

    private function getDivByZeroExceptionAction(
        Entity $leftNumber,
        Entity $rightNumber,
        int $precision
    ): ActionInterface {
        $rightRealNumberNumberDataItem = $this->createDataItem(
            $rightNumber->getRealNumber(),
            $rightNumber->getRealNumber(),
            $precision,
            self::RETURN_VALUE_OF_RIGHT_REAL_NUMBER_MUL
        );
        $rightImaginaryNumberNumberDataItem = $this->createDataItem(
            $rightNumber->getImaginaryNumber(),
            $rightNumber->getImaginaryNumber(),
            $precision,
            self::RETURN_VALUE_OF_RIGHT_IMAGINARY_NUMBER_MUL
        );

        $addAction = $this->getRealNumberAction(
            AddInterface::class,
            [
                $this->createDataItem(
                    self::RETURN_VALUE_OF_FIRST_REAL_MUL,
                    self::RETURN_VALUE_OF_SECOND_REAL_MUL,
                    $precision,
                    self::RETURN_VALUE_OF_REAL_SUM_MUL
                ),
                $this->createDataItem(
                    self::RETURN_VALUE_OF_RIGHT_REAL_NUMBER_MUL,
                    self::RETURN_VALUE_OF_RIGHT_IMAGINARY_NUMBER_MUL,
                    $precision,
                    self::RETURN_VALUE_OF_SUM_OF_SQUARE
                )
            ]
        );

        $subAction = $this->getRealNumberAction(
            SubInterface::class,
            []
        );

        $mulAction = $this->getRealNumberAction(
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
                $rightRealNumberNumberDataItem,
                $rightImaginaryNumberNumberDataItem
            ]
        );

        $divAction = $realNumberAction = $this->getMockBuilder(DivInterface::class)
            ->disableOriginalConstructor()
            ->getMock();

        $divAction
            ->expects(self::exactly(1))
            ->method('execute')
            ->will($this->throwException(new \DivisionByZeroError()));


        return new Div(
            $addAction,
            $subAction,
            $mulAction,
            $divAction
        );
    }
}