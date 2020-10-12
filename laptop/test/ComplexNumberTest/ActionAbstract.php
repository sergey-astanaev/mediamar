<?php

namespace ComplexNumberTest;

use Laptop\ComplexNumber\Action\ActionInterface;
use Laptop\ComplexNumber\Entity;
use PHPUnit\Framework\MockObject\MockObject;
use PHPUnit\Framework\TestCase;

abstract class ActionAbstract extends TestCase
{
    protected const LEFT_REAL_NUMBER = 0.01;
    protected const RIGHT_REAL_NUMBER = 0.001;
    protected const LEFT_IMAGINARY_NUMBER = 1.1;
    protected const RIGHT_IMAGINARY_NUMBER = 0.1;

    protected const PRECISION = 3;

    protected const EXPECTED_RETURN_REAL_NUMBER = 1.000;
    protected const EXPECTED_RETURN_IMAGINARY_NUMBER = 0.011;

    public function testElementaryAction(): void
    {
        $leftNumber = new Entity(self::LEFT_REAL_NUMBER, self::LEFT_IMAGINARY_NUMBER);
        $rightNumber = new Entity(self::RIGHT_REAL_NUMBER, self::RIGHT_IMAGINARY_NUMBER);

        $action = $this->getAction(
            $leftNumber,
            $rightNumber,
            self::EXPECTED_RETURN_REAL_NUMBER,
            self::EXPECTED_RETURN_IMAGINARY_NUMBER,
            self::PRECISION
        );

        $returnValue = $action->execute(
            $leftNumber,
            $rightNumber,
            self::PRECISION
        );

        self::assertEquals(self::EXPECTED_RETURN_REAL_NUMBER, $returnValue->getRealNumber());
        self::assertEquals(self::EXPECTED_RETURN_IMAGINARY_NUMBER, $returnValue->getImaginaryNumber());
    }

    abstract protected function getAction(
        Entity $leftNumber,
        Entity $rightNumber,
        float $expectedRealNumber,
        float $expectedImaginaryNumber,
        int $precision
    ): ActionInterface;

    final protected function getRealNumberAction(string $actionInterface, array $dataList): MockObject
    {
        $realNumberAction = $this->getMockBuilder($actionInterface)
            ->disableOriginalConstructor()
            ->getMock();

        foreach ($dataList as $index => $data) {
            $realNumberAction->expects(self::at($index))
                ->method('execute')
                ->with(
                    self::equalTo($data['leftNumber']),
                    self::equalTo($data['rightNumber']),
                    self::equalTo($data['precision'])
                )->willReturn($data['returnValue']);
        }


        return $realNumberAction;
    }

    final protected function createDataItem(float $leftNumber, float $rightNumber, int $precision, float $returnValue): array
    {
        return [
            'leftNumber' => $leftNumber,
            'rightNumber' => $rightNumber,
            'precision' => $precision,
            'returnValue' => $returnValue,
        ];
    }
}