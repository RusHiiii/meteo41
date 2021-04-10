<?php


namespace App\Tests\Unit\Converter;

use App\Core\Converter\Weather\CloudBaseConverter;
use App\Tests\TestCase;

class CloudBaseConverterTest extends TestCase
{
    /**
     * @var CloudBaseConverter
     */
    private $cloudBaseonverter;

    protected function setUp()
    {
        parent::setUp();
        $this->cloudBaseonverter = self::$container->get(CloudBaseConverter::class);
    }

    /**
     * @dataProvider dataProvider
     */
    public function testConvertCloudBase($feet, $m)
    {
        $result = $this->cloudBaseonverter->convertImperialToMetric($feet);

        $this->assertEquals($m, $result);
    }

    public function dataProvider()
    {
        return [
            [
                909,
                277
            ],
            [
                2600,
                792
            ]
        ];
    }
}