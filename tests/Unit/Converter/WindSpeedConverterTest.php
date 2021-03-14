<?php


namespace App\Tests\Unit\Converter;

use App\Core\Converter\WindSpeedConverter;
use App\Tests\TestCase;

class WindSpeedConverterTest extends TestCase
{
    /**
     * @var WindSpeedConverter
     */
    private $windSpeedConverter;

    protected function setUp()
    {
        parent::setUp();
        $this->windSpeedConverter = self::$container->get(WindSpeedConverter::class);
    }

    /**
     * @dataProvider dataProvider
     */
    public function testConvertWindSpeed($mph, $kmh)
    {
        $result = $this->windSpeedConverter->convertImperialToMetric($mph);

        $this->assertEquals($kmh, $result);
    }

    public function dataProvider()
    {
        return [
            [
                4.5,
                7.2
            ],
            [
                9.2,
                14.8
            ],
            [
                35.0,
                56.3
            ],
            [
                3.2,
                5.1
            ]
        ];
    }
}