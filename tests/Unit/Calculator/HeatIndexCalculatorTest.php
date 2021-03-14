<?php


namespace App\Tests\Unit\Calculator;

use App\Core\Calculator\HeatIndexCalculator;
use App\Tests\TestCase;

class HeatIndexCalculatorTest extends TestCase
{
    /**
     * @var HeatIndexCalculator
     */
    private $heatIndexCalculator;

    protected function setUp()
    {
        parent::setUp();
        $this->heatIndexCalculator = self::$container->get(HeatIndexCalculator::class);
    }

    /**
     * @dataProvider dataProvider
     */
    public function testHeatIndexCalculator($tempF, $humidity, $expected)
    {
        $result = $this->heatIndexCalculator->getHeatIndex($tempF, $humidity);

        $this->assertEquals($expected, $result);
    }

    public function dataProvider()
    {
        return [
            [
                50.9,
                72,
                49.1
            ],
            [
                73.0,
                48,
                72.3
            ],
            [
                63.0,
                58,
                61.7
            ]
        ];
    }
}