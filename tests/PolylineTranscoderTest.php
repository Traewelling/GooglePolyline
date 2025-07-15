<?php

use PHPUnit\Framework\Attributes\DataProvider;
use PHPUnit\Framework\TestCase;
use Traewelling\GooglePolyline\dto\Location;
use Traewelling\GooglePolyline\PolylineTranscoder;

class PolylineTranscoderTest extends TestCase
{
    public static function polylineDataProvider(): array
    {
        return [
            'Karlsruhe' => [
                [
                    [49.01353, 8.40437], [49.00984, 8.39736], [49.00979, 8.39951], [49.01148, 8.40157], [49.01107, 8.40234], [49.00971, 8.40126], [49.00966, 8.40271], [49.01087, 8.40316], [49.01074, 8.40415], [49.00957, 8.40395], [49.01074, 8.40415], [49.01074, 8.40504], [49.00953, 8.40531], [49.00941, 8.40682], [49.01090, 8.40599], [49.01118, 8.40688], [49.00935, 8.40842], [49.00931, 8.41035], [49.01353, 8.40437],
                ],
                'q}cjHinhr@`Vxj@HmLqI{KpAyCnGvEHaHqFyAXeEhFf@iFg@?qDpFu@VmHiHdDw@qDlJsHFaKkYjd@',
            ],
            'Chicago' => [
                [
                    [41.85555, -87.70262], [41.85555, -87.69524], [41.86623, -87.69550], [41.86642, -87.70297], [41.86309, -87.70305], [41.86284, -87.71953], [41.86194, -87.71953], [41.86252, -87.70301], [41.85552, -87.70280],
                ],
                'e|m~FjlhvO?cm@waAr@e@tm@xSNp@~eBrD?sBgfBvj@i@'
            ],
            'Jumping the prime meridian' => [
                [
                    [51.47806, -0.00158], [51.47836, 0.00096], [51.47725, -0.00298], [51.47720, 0.00129],
                ],
                '{heyHzH{@{N|ErWHuY'
            ],
            'Jumping the equator' => [
                [
                    [-3.72815, -14.64739], [4.00034, -4.80364], [-2.67512, 3.63386], [3.64956, 16.29011], [-1.62119, 23.67293],
                ],
                '|cwUdykxAandn@mra{@rxvg@k}nr@ghre@q|flAdmd_@s}`l@'
            ],
            'Down-under' => [
                [
                    [-37.81502, 144.74313], [-37.80634, 144.82003], [-37.64993, 144.80905], [-37.64124, 144.94637], [-37.78898, 144.95187], [-37.77595, 145.08096], [-37.97974, 144.91891], [-37.81394, 144.74451],
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
                    [48.784600, 9.183700], [48.993500, 8.401900], [48.585110, 7.733882], [48.876743, 2.358424]
                ],
                'olq`|Ag|ooPg_wKn}un@js|Wbvwg@arxPb}agI'
            ],
            'London -> Paris' => [
                [
                    [51.531425, -0.126133], [48.880947, 2.355314]
                ],
                'aifhaBhjuFzuw`DmqmvC'
            ],
        ];
    }

    public function testPolylineTranscoder()
    {
        $test = new PolylineTranscoder();

        $coordinates = [
            [13.4050, 52.5200], // Berlin
            [13.4051, 52.5101], // Slightly different point in Berlin
            [13.4060, 52.5210],  // Another point in Berlin
            [41.87343, -87.68840] // Chicago
        ];
        $encodedPolyline = $test->encodePolyline($coordinates);
        $decodedCoordinates = $test->decodePolyline($encodedPolyline);

        foreach ($decodedCoordinates as $key => $coordinate) {
            $this->assertInstanceOf(Location::class, $coordinate);
            $this->assertEquals($coordinates[$key][1], (string)$coordinate->getLatitude());
            $this->assertEquals($coordinates[$key][0], (string)$coordinate->getLongitude());
        }
    }

    public function testNonStandardPolylineEncodeDecode()
    {
        $test = new PolylineTranscoder();

        $coordinates = [
            [13.4050, 52.5200], // Berlin
            [13.4051, 52.5101], // Slightly different point in Berlin
            [13.4060, 52.5210],  // Another point in Berlin
            [41.87343, -87.68840] // Chicago
        ];
        $encodedPolyline = $test->encodePolyline($coordinates, 6);
        $decodedCoordinates = $test->decodePolyline($encodedPolyline, 6);

        foreach ($decodedCoordinates as $key => $coordinate) {
            $this->assertInstanceOf(Location::class, $coordinate);
            $this->assertEquals($coordinates[$key][1], (string)$coordinate->getLatitude());
            $this->assertEquals($coordinates[$key][0], (string)$coordinate->getLongitude());
        }
    }

    #[DataProvider('nonStandardPolylineDataProvider')]
    public function testNonStandardPolyline($expected, $polyline): void
    {
        $test = new PolylineTranscoder();
        $decodedCoordinates = $test->decodePolyline($polyline, 6);

        foreach ($decodedCoordinates as $key => $coordinate) {
            $this->assertInstanceOf(Location::class, $coordinate);
            $this->assertEquals($expected[$key][0], (string)$coordinate->getLatitude());
            $this->assertEquals($expected[$key][1], (string)$coordinate->getLongitude());
        }
    }

    #[DataProvider('polylineDataProvider')]
    public function testPolylineDecode($expected, $polyline)
    {
        $test = new PolylineTranscoder();
        $decodedCoordinates = $test->decodePolyline($polyline);

        foreach ($decodedCoordinates as $key => $coordinate) {
            $this->assertInstanceOf(Location::class, $coordinate);
            $this->assertEquals($expected[$key][1], (string)$coordinate->getLongitude());
            $this->assertEquals($expected[$key][0], (string)$coordinate->getLatitude());
        }
    }
}
