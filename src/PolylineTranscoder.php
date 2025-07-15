<?php

declare(strict_types=1);

namespace Traewelling\GooglePolyline;


use Traewelling\GooglePolyline\dto\Decimal;
use Traewelling\GooglePolyline\dto\Location;

class PolylineTranscoder
{
    /**
     * @param array<array<float|int>> $coordinates Coordinates in the format [[longitude, latitude], ...]
     * @param int $precision
     * @return string
     */
    public function encodePolyline(array $coordinates, int $precision = 5): string
    {
        $polyline = '';
        $prevLat = 0;
        $prevLon = 0;

        foreach ($coordinates as $coordinate) {
            $latitude = round($coordinate[1] * 10 ** $precision);
            $longitude = round($coordinate[0] * 10 ** $precision);

            $deltaLat = $latitude - $prevLat;
            $deltaLon = $longitude - $prevLon;

            $polyline .= $this->encodeValue($deltaLat) . $this->encodeValue($deltaLon);

            $prevLat = $latitude;
            $prevLon = $longitude;
        }

        return $polyline;
    }

    private function encodeValue(float|int $value): string
    {
        $value = ($value < 0) ? ~($value << 1) : ($value << 1);
        $encoded = '';

        while ($value >= 0x20) {
            $encoded .= chr((0x20 | ($value & 0x1F)) + 63);
            $value >>= 5;
        }

        $encoded .= chr((int) ($value + 63));

        return $encoded;
    }

    /**
     * @param string $polyline
     * @param int $precision
     * @return Location[]
     */
    public function decodePolyline(string $polyline, int $precision = 5): array
    {
        $index = 0;
        $points = [];
        $latitude = 0;
        $longitude = 0;

        while ($index < strlen($polyline)) {
            $latitude += $this->calculatePart($polyline, $index);
            $longitude += $this->calculatePart($polyline, $index);

            $points[] =
                new Location(
                    $this->precision($latitude, $precision),
                    $this->precision($longitude, $precision)
                );

        }

        return $points;
    }

    /**
     * PHP has a few problems converting floats to strings with high precision.
     * This method ensures that we get the correct precision without any rounding issues.
     * @param float|int $input
     * @param int $precision
     * @return Decimal
     */
    private function precision(float|int $input, int $precision): Decimal
    {
        // all examples are with 5 precision, so we can use that as default
        // 1. get the correct number: -158 -> -0.00158 // 5147806 -> 51.47806
        $number = $input * (10 ** -$precision);
        // 2. get the integer part: -0.00158 -> 0 // 51.47806 -> 51
        $intVal = intval($number);

        if ($intVal === 0) {
            // if the integer part is 0, we maybe have to remove the sign
            $fractional = substr((string)$input, $input < 0 ? 1 : 0);
        } else {
            // if the integer part is not 0, we can just use the string representation of the integer part
            $fractional = substr((string)$input, strlen((string)$intVal));
        }

        return new Decimal($intVal, (int)$fractional, $precision, $input < 0);
    }

    private function calculatePart(string $polyline, int &$index): int
    {
        $shift = 0;
        $result = 0;

        do {
            $byte = ord($polyline[$index++]) - 63;
            $result |= ($byte & 0x1F) << $shift;
            $shift += 5;
        } while ($byte >= 0x20);

        return ($result & 1) ? ~($result >> 1) : ($result >> 1);
    }
}
