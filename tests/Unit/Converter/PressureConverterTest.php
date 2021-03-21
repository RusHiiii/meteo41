<?php


namespace App\Tests\Unit\Converter;

use App\Core\Converter\Weather\RainfallConverter;
use App\Tests\TestCase;

class PressureConverterTest extends TestCase
{
    /**
     * @var RainfallConverter
     */
    private $rainfallConverter;

    protected function setUp()
    {
        parent::setUp();
        $this->rainfallConverter = self::$container->get(RainfallConverter::class);
    }

    /**
     * @dataProvider dataProvider
     */
    public function testConvertRainfall($in, $mm)
    {
        $result = $this->rainfallConverter->convertImperialToMetric($in);

        $this->assertEquals($mm, $result);
    }

    public function dataProvider()
    {
        return [
            [
                6.039,
                153.4
            ],
            [
                0.480,
                12.2
            ],
            [
                13.930,
                353.8
            ]
        ];
    }
}