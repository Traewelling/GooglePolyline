<?php

declare(strict_types=1);

namespace Traewelling\GooglePolyline\dto;

class Decimal
{
    private int $integerPart;
    private int $fractionalPart;
    private int $precision;
    private bool $negative;

    public function __construct(int $integerPart, int $fractionalPart, int $precision = 5, ?bool $negative = null)
    {
        $this->negative = $negative !== null ? $negative : ($integerPart < 0);
        $this->integerPart = abs($integerPart);
        $this->fractionalPart = $fractionalPart;
        $this->precision = $precision;
    }

    public function getIntegerPart(): int
    {
        return $this->integerPart;
    }

    public function setIntegerPart(int $integerPart): Decimal
    {
        $this->integerPart = $integerPart;
        return $this;
    }

    public function getFractionalPart(): int
    {
        return $this->fractionalPart;
    }

    public function setFractionalPart(int $fractionalPart): Decimal
    {
        $this->fractionalPart = $fractionalPart;
        return $this;
    }

    public function getPrecision(): int
    {
        return $this->precision;
    }

    public function setPrecision(int $precision): Decimal
    {
        $this->precision = $precision;
        return $this;
    }

    public function toFloat(): float
    {
        return (float)$this->__toString();
    }

    public function __toString(): string
    {
        return sprintf(
            '%s%d.%s',
            $this->negative ? '-' : '',
            $this->integerPart,
            str_pad((string)$this->fractionalPart, $this->precision, '0', STR_PAD_LEFT)
        );
    }
}
