<?php

namespace e2e;

use Clickbar\Magellan\Data\Geometries\Point;
use PHPUnit\Framework\Attributes\DataProvider;
use PHPUnit\Framework\TestCase;
use Traewelling\GooglePolyline\MagellanPolylineTranscoder;

class MagellanPolylineTranscoderTest extends TestCase
{
    public static function polylineDataProvider(): array
    {
        return [
            'Karlsruhe' => [
                [
                    Point::make(x: 49.01353, y: 8.40437, srid: 4326), Point::make(x: 49.00984, y: 8.39736, srid: 4326), Point::make(x: 49.00979, y: 8.39951, srid: 4326), Point::make(x: 49.01148, y: 8.40157, srid: 4326), Point::make(x: 49.01107, y: 8.40234, srid: 4326), Point::make(x: 49.00971, y: 8.40126, srid: 4326), Point::make(x: 49.00966, y: 8.40271, srid: 4326), Point::make(x: 49.01087, y: 8.40316, srid: 4326), Point::make(x: 49.01074, y: 8.40415, srid: 4326), Point::make(x: 49.00957, y: 8.40395, srid: 4326), Point::make(x: 49.01074, y: 8.40415, srid: 4326), Point::make(x: 49.01074, y: 8.40504, srid: 4326), Point::make(x: 49.00953, y: 8.40531, srid: 4326), Point::make(x: 49.00941, y: 8.40682, srid: 4326), Point::make(x: 49.01090, y: 8.40599, srid: 4326), Point::make(x: 49.01118, y: 8.40688, srid: 4326), Point::make(x: 49.00935, y: 8.40842, srid: 4326), Point::make(x: 49.00931, y: 8.41035, srid: 4326), Point::make(x: 49.01353, y: 8.40437, srid: 4326),
                ],
                'q}cjHinhr@`Vxj@HmLqI{KpAyCnGvEHaHqFyAXeEhFf@iFg@?qDpFu@VmHiHdDw@qDlJsHFaKkYjd@',
            ],
            'Chicago' => [
                [
                    Point::make(x: 41.85555, y: -87.70262, srid: 4326), Point::make(x: 41.85555, y: -87.69524, srid: 4326), Point::make(x: 41.86623, y: -87.69550, srid: 4326), Point::make(x: 41.86642, y: -87.70297, srid: 4326), Point::make(x: 41.86309, y: -87.70305, srid: 4326), Point::make(x: 41.86284, y: -87.71953, srid: 4326), Point::make(x: 41.86194, y: -87.71953, srid: 4326), Point::make(x: 41.86252, y: -87.70301, srid: 4326), Point::make(x: 41.85552, y: -87.70280, srid: 4326),
                ],
                'e|m~FjlhvO?cm@waAr@e@tm@xSNp@~eBrD?sBgfBvj@i@'
            ],
            'Jumping the prime meridian' => [
                [
                    Point::make(x: 51.47806, y: -0.00158, srid: 4326), Point::make(x: 51.47836, y: 0.00096, srid: 4326), Point::make(x: 51.47725, y: -0.00298, srid: 4326), Point::make(x: 51.47720, y: 0.00129, srid: 4326),
                ],
                '{heyHzH{@{N|ErWHuY'
            ],
            'Jumping the equator' => [
                [
                    Point::make(x: -3.72815, y: -14.64739, srid: 4326), Point::make(x: 4.00034, y: -4.80364, srid: 4326), Point::make(x: -2.67512, y: 3.63386, srid: 4326), Point::make(x: 3.64956, y: 16.29011, srid: 4326), Point::make(x: -1.62119, y: 23.67293, srid: 4326),
                ],
                '|cwUdykxAandn@mra{@rxvg@k}nr@ghre@q|flAdmd_@s}`l@'
            ],
            'Down-under' => [
                [
                    Point::make(x: -37.81502, y: 144.74313, srid: 4326), Point::make(x: -37.80634, y: 144.82003, srid: 4326), Point::make(x: -37.64993, y: 144.80905, srid: 4326), Point::make(x: -37.64124, y: 144.94637, srid: 4326), Point::make(x: -37.78898, y: 144.95187, srid: 4326), Point::make(x: -37.77595, y: 145.08096, srid: 4326), Point::make(x: -37.97974, y: 144.91891, srid: 4326), Point::make(x: -37.81394, y: 144.74451, srid: 4326),
                ],
                'zvxeFqcmrZgu@s_Nqp]rcAiu@gyYjz[ka@mpAyeXtxf@xs^gk_@~`a@'
            ]
        ];
    }

    public static function nonStandardPolylineDataProvider(): array
    {
        return [
            'Towards Stuttgart' => [
                [
                    Point::make(x: 48.784600, y: 9.183700, srid: 4326), Point::make(x: 48.993500, y: 8.401900, srid: 4326), Point::make(x: 48.585110, y: 7.733882, srid: 4326), Point::make(x: 48.876743, y: 2.358424, srid: 4326)
                ],
                'olq`|Ag|ooPg_wKn}un@js|Wbvwg@arxPb}agI'
            ],
            'London -> Paris' => [
                [
                    Point::make(x: 51.531425, y: -0.126133, srid: 4326), Point::make(x: 48.880947, y: 2.355314, srid: 4326)
                ],
                'aifhaBhjuFzuw`DmqmvC'
            ],
        ];
    }

    public function testMagellanPolylineTranscoder()
    {
        $test = new MagellanPolylineTranscoder();

        $coordinates = [
            Point::make(x: 13.4050, y: 52.5200, srid: 4326), // Berlin
            Point::make(x: 13.4051, y: 52.5101, srid: 4326), // Slightly different point in Berlin
            Point::make(x: 13.4060, y: 52.5210, srid: 4326),  // Another point in Berlin
            Point::make(x: 41.87343, y: -87.68840, srid: 4326) // Chicago
        ];
        $encodedPolyline = $test->encodePolyline($coordinates);
        $decodedCoordinates = $test->decodePolyline($encodedPolyline);

        foreach ($decodedCoordinates as $key => $coordinate) {
            $this->assertInstanceOf(Point::class, $coordinate);
            $this->assertEquals($coordinates[$key]->getX(), (string)$coordinate->getX());
            $this->assertEquals($coordinates[$key]->getY(), (string)$coordinate->getY());
        }
    }

    public function testNonStandardPolylineEncodeDecode()
    {
        $test = new MagellanPolylineTranscoder();

        $coordinates = [
            Point::make(x: 13.4050, y: 52.5200, srid: 4326), // Berlin
            Point::make(x: 13.4051, y: 52.5101, srid: 4326), // Slightly different point in Berlin
            Point::make(x: 13.4060, y: 52.5210, srid: 4326),  // Another point in Berlin
            Point::make(x: 41.87343, y: -87.68840, srid: 4326) // Chicago
        ];
        $encodedPolyline = $test->encodePolyline($coordinates, 6);
        $decodedCoordinates = $test->decodePolyline($encodedPolyline, 6);

        foreach ($decodedCoordinates as $key => $coordinate) {
            $this->assertInstanceOf(Point::class, $coordinate);
            $this->assertEquals($coordinates[$key]->getX(), (string)$coordinate->getX());
            $this->assertEquals($coordinates[$key]->getY(), (string)$coordinate->getY());
        }
    }

    #[DataProvider('nonStandardPolylineDataProvider')]
    public function testNonStandardPolyline($expected, $polyline): void
    {
        $test = new MagellanPolylineTranscoder();
        $decodedCoordinates = $test->decodePolyline($polyline, 6);

        foreach ($decodedCoordinates as $key => $coordinate) {
            $this->assertInstanceOf(Point::class, $coordinate);
            $this->assertEquals($expected[$key]->getX(), (string)$coordinate->getX());
            $this->assertEquals($expected[$key]->getY(), (string)$coordinate->getY());
        }
    }

    #[DataProvider('polylineDataProvider')]
    public function testPolylineDecode($expected, $polyline)
    {
        $test = new MagellanPolylineTranscoder();
        $decodedCoordinates = $test->decodePolyline($polyline);

        foreach ($decodedCoordinates as $key => $coordinate) {
            $this->assertInstanceOf(Point::class, $coordinate);
            $this->assertEquals($expected[$key]->getX(), (string)$coordinate->getX());
            $this->assertEquals($expected[$key]->getY(), (string)$coordinate->getY());
        }
    }
}
