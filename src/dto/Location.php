<?php

namespace Traewelling\GooglePolyline\dto;

class Location
{
    private Decimal $latitude;
    private Decimal $longitude;

    public function __construct(Decimal $latitude, Decimal $longitude)
    {
        $this->latitude = $latitude;
        $this->longitude = $longitude;
    }

    public function getLatitude(): float
    {
        return $this->latitude->toFloat();
    }

    public function getLongitude(): float
    {
        return $this->longitude->toFloat();
    }

    public function setLatitude(Decimal $latitude): void
    {
        $this->latitude = $latitude;
    }

    public function setLongitude(Decimal $longitude): void
    {
        $this->longitude = $longitude;
    }

    public function __toString(): string
    {
        return sprintf('(%s, %s)', $this->latitude, $this->longitude);
    }
}
