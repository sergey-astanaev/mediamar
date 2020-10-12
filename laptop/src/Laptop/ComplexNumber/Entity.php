<?php

namespace Laptop\ComplexNumber;

class Entity
{
    /**
     * @var float
     */
    private $realNumber;

    /**
     * @var float
     */
    private $imaginaryNumber;

    public function __construct(float $realNumber, float $imaginaryNumber)
    {
        $this->realNumber = $realNumber;
        $this->imaginaryNumber = $imaginaryNumber;
    }

    public function getRealNumber(): float
    {
        return $this->realNumber;
    }

    public function getImaginaryNumber(): float
    {
        return $this->imaginaryNumber;
    }
}