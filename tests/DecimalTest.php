<?php

declare(strict_types=1);

use PHPUnit\Framework\Attributes\DataProvider;
use PHPUnit\Framework\TestCase;
use Traewelling\GooglePolyline\dto\Decimal;

class DecimalTest extends TestCase
{
    public static function decimalDataProvider(): array
    {
        return [
            ['123.45600', 123, 45600],
            ['-123.00456', -123, 456],
            ['0.00456', 0, 456],
            ['123.00001', 123, 1, 5],
            ['-123.00001', -123, 1, 5],
            ['0.00001', 0, 1, 5],
            ['123.456789', 123, 456789, 6],
            ['-123.456789', -123, 456789, 6],
        ];
    }

    public function testCanRetrieveIntegerPart(): void
    {
        $decimal = new Decimal(123, 456);
        $this->assertSame(123, $decimal->getIntegerPart());
    }

    public function testCanSetIntegerPart(): void
    {
        $decimal = new Decimal(123, 456);
        $decimal->setIntegerPart(789);
        $this->assertSame(789, $decimal->getIntegerPart());
    }

    public function testCanRetrieveFractionalPart(): void
    {
        $decimal = new Decimal(123, 456);
        $this->assertSame(456, $decimal->getFractionalPart());
    }

    public function testCanSetFractionalPart(): void
    {
        $decimal = new Decimal(123, 456);
        $decimal->setFractionalPart(789);
        $this->assertSame(789, $decimal->getFractionalPart());
    }

    public function testCanRetrievePrecision(): void
    {
        $decimal = new Decimal(123, 456, 3);
        $this->assertSame(3, $decimal->getPrecision());
    }

    public function testCanSetPrecision(): void
    {
        $decimal = new Decimal(123, 456, 3);
        $decimal->setPrecision(7);
        $this->assertSame(7, $decimal->getPrecision());
    }

    public function testConvertsToFloatCorrectly(): void
    {
        $decimal = new Decimal(123, 456);
        $this->assertSame(123.00456, $decimal->toFloat());
    }

    public function testConvertsToStringCorrectly(): void
    {
        $decimal = new Decimal(123, 456);
        $this->assertSame('123.00456', (string)$decimal);
    }

    public function testHandlesZeroFractionalPart(): void
    {
        $decimal = new Decimal(123, 0);
        $this->assertSame('123.00000', (string)$decimal);
    }

    public function testHandlesNegativeIntegerPart(): void
    {
        $decimal = new Decimal(-123, 45600);
        $this->assertSame('-123.45600', (string)$decimal);
    }

    #[DataProvider('decimalDataProvider')]
    public function testMultipleDecimals($expected, $integerPart, $fractionalPart, $precision = 5): void
    {
        $decimal = new Decimal($integerPart, $fractionalPart, $precision);
        $this->assertSame($expected, (string)$decimal);
    }
}