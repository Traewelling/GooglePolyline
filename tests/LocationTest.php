<?php

declare(strict_types=1);

use PHPUnit\Framework\TestCase;
use Traewelling\GooglePolyline\dto\Decimal;
use Traewelling\GooglePolyline\dto\Location;

class LocationTest extends TestCase
{

    public function testCanCreateLocation(): void
    {
        $latitude = new Decimal(49, 1353);
        $longitude = new Decimal(8, 40437);
        $location = new Location($latitude, $longitude);

        $this->assertSame(49.01353, $location->getLatitude());
        $this->assertSame(8.40437, $location->getLongitude());
    }

    public function testCanSetLatitudeAndLongitude(): void
    {
        $location = new Location(new Decimal(0, 0), new Decimal(0, 0));
        $location->setLatitude(new Decimal(51, 47806));
        $location->setLongitude(new Decimal(0, 158, 5, true));

        $this->assertSame(51.47806, $location->getLatitude());
        $this->assertSame(-0.00158, $location->getLongitude());
    }

    public function testToString(): void
    {
        $latitude = new Decimal(51, 47806);
        $longitude = new Decimal(0, 158, 5, true);
        $location = new Location($latitude, $longitude);

        $this->assertSame('(51.47806, -0.00158)', (string) $location);
    }
}