<?php

namespace Traewelling\GooglePolyline;

use Clickbar\Magellan\Data\Geometries\Point;

class MagellanPolylineTranscoder
{
    private PolylineTranscoder $polylineTranscoder;

    public function __construct(?PolylineTranscoder $polylineTranscoder = null)
    {
        $this->polylineTranscoder = $polylineTranscoder ?? new PolylineTranscoder();
    }

    /**
     * @param Point[] $coordinates
     * @param int $precision
     * @return string
     */
    public function encodePolyline(array $coordinates, int $precision = 5): string
    {
        $floatCoordinates = [];
        foreach ($coordinates as $coordinate) {
            $floatCoordinates[] = [$coordinate->getX(), $coordinate->getY()];
        }

        return $this->polylineTranscoder->encodePolyline($floatCoordinates, $precision);
    }

    /**
     * @param string $polyline
     * @param int $precision
     * @param int $srid
     * @return array<Point>
     */
    public function decodePolyline(string $polyline, int $precision = 5, int $srid = 4326): array
    {
        $coordinates = $this->polylineTranscoder->decodePolyline($polyline, $precision);

        $points = [];
        foreach ($coordinates as $coordinate) {
            $points[] = Point::make(x: $coordinate->getLongitude(), y: $coordinate->getLatitude(), srid: $srid);
        }

        return $points;
    }
}
