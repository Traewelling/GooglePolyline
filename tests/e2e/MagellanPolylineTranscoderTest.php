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
                    Point::make(x: 8.40437, y: 49.01353, srid: 4326), Point::make(x: 8.39736, y: 49.00984, srid: 4326), Point::make(x: 8.39951, y: 49.00979, srid: 4326), Point::make(x: 8.40157, y: 49.01148, srid: 4326), Point::make(x: 8.40234, y: 49.01107, srid: 4326), Point::make(x: 8.40126, y: 49.00971, srid: 4326), Point::make(x: 8.40271, y: 49.00966, srid: 4326), Point::make(x: 8.40316, y: 49.01087, srid: 4326), Point::make(x: 8.40415, y: 49.01074, srid: 4326), Point::make(x: 8.40395, y: 49.00957, srid: 4326), Point::make(x: 8.40415, y: 49.01074, srid: 4326), Point::make(x: 8.40504, y: 49.01074, srid: 4326), Point::make(x: 8.40531, y: 49.00953, srid: 4326), Point::make(x: 8.40682, y: 49.00941, srid: 4326), Point::make(x: 8.40599, y: 49.01090, srid: 4326), Point::make(x: 8.40688, y: 49.01118, srid: 4326), Point::make(x: 8.40842, y: 49.00935, srid: 4326), Point::make(x: 8.41035, y: 49.00931, srid: 4326), Point::make(x: 8.40437, y: 49.01353, srid: 4326),
                ],
                'q}cjHinhr@`Vxj@HmLqI{KpAyCnGvEHaHqFyAXeEhFf@iFg@?qDpFu@VmHiHdDw@qDlJsHFaKkYjd@',
            ],
            'Chicago' => [
                [
                    Point::make(x: -87.70262, y: 41.85555, srid: 4326), Point::make(x: -87.69524, y: 41.85555, srid: 4326), Point::make(x: -87.69550, y: 41.86623, srid: 4326), Point::make(x: -87.70297, y: 41.86642, srid: 4326), Point::make(x: -87.70305, y: 41.86309, srid: 4326), Point::make(x: -87.71953, y: 41.86284, srid: 4326), Point::make(x: -87.71953, y: 41.86194, srid: 4326), Point::make(x: -87.70301, y: 41.86252, srid: 4326), Point::make(x: -87.70280, y: 41.85552, srid: 4326),
                ],
                'e|m~FjlhvO?cm@waAr@e@tm@xSNp@~eBrD?sBgfBvj@i@'
            ],
            'Jumping the prime meridian' => [
                [
                    Point::make(x: -0.00158, y: 51.47806, srid: 4326), Point::make(x: 0.00096, y: 51.47836, srid: 4326), Point::make(x: -0.00298, y: 51.47725, srid: 4326), Point::make(x: 0.00129, y: 51.47720, srid: 4326),
                ],
                '{heyHzH{@{N|ErWHuY'
            ],
            'Jumping the equator' => [
                [
                    Point::make(x: -14.64739, y: -3.72815, srid: 4326), Point::make(x: -4.80364, y: 4.00034, srid: 4326), Point::make(x: 3.63386, y: -2.67512, srid: 4326), Point::make(x: 16.29011, y: 3.64956, srid: 4326), Point::make(x: 23.67293, y: -1.62119, srid: 4326),
                ],
                '|cwUdykxAandn@mra{@rxvg@k}nr@ghre@q|flAdmd_@s}`l@'
            ],
            'Down-under' => [
                [
                    Point::make(x: 144.74313, y: -37.81502, srid: 4326), Point::make(x: 144.82003, y: -37.80634, srid: 4326), Point::make(x: 144.80905, y: -37.64993, srid: 4326), Point::make(x: 144.94637, y: -37.64124, srid: 4326), Point::make(x: 144.95187, y: -37.78898, srid: 4326), Point::make(x: 145.08096, y: -37.77595, srid: 4326), Point::make(x: 144.91891, y: -37.97974, srid: 4326), Point::make(x: 144.74451, y: -37.81394, srid: 4326),
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
                    Point::make(x: 9.183700, y: 48.784600, srid: 4326), Point::make(x: 8.401900, y: 48.993500, srid: 4326), Point::make(x: 7.733882, y: 48.585110, srid: 4326), Point::make(x: 2.358424, y: 48.876743, srid: 4326)
                ],
                'olq`|Ag|ooPg_wKn}un@js|Wbvwg@arxPb}agI'
            ],
            'London -> Paris' => [
                [
                    Point::make(x: -0.126133, y: 51.531425, srid: 4326), Point::make(x: 2.355314, y: 48.880947, srid: 4326)
                ],
                'aifhaBhjuFzuw`DmqmvC'
            ],
        ];
    }

    public function testMagellanPolylineTranscoder()
    {
        $test = new MagellanPolylineTranscoder();

        $coordinates = [
            Point::make(x: 52.5200, y: 13.4050, srid: 4326), // Berlin
            Point::make(x: 52.5101, y: 13.4051, srid: 4326), // Slightly different point in Berlin
            Point::make(x: 52.5210, y: 13.4060, srid: 4326),  // Another point in Berlin
            Point::make(x: -87.68840, y: 41.87343, srid: 4326) // Chicago
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
            Point::make(x: 52.5200, y: 13.4050, srid: 4326), // Berlin
            Point::make(x: 52.5101, y: 13.4051, srid: 4326), // Slightly different point in Berlin
            Point::make(x: 52.5210, y: 13.4060, srid: 4326),  // Another point in Berlin
            Point::make(x: -87.68840, y: 41.87343, srid: 4326) // Chicago
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
