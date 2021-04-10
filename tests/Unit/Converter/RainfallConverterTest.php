<?php


namespace App\Tests\Unit\Converter;

use App\Core\Converter\Weather\TemperatureConverter;
use App\Tests\TestCase;

class RainfallConverterTest extends TestCase
{
    /**
     * @var TemperatureConverter
     */
    private $temperatureConverter;

    protected function setUp()
    {
        parent::setUp();
        $this->temperatureConverter = self::$container->get(TemperatureConverter::class);
    }

    /**
     * @dataProvider dataProvider
     */
    public function testConvertTemperature($fahrenheit, $celsius)
    {
        $result = $this->temperatureConverter->convertImperialToMetric($fahrenheit);

        $this->assertEquals($celsius, $result);
    }

    public function dataProvider()
    {
        return [
            [
                50.4,
                10.2
            ],
            [
                21.9,
                -5.6
            ],
            [
                75.6,
                24.2
            ],
            [
                75.9,
                24.4
            ],
            [
                32,
                0
            ]
        ];
    }
}