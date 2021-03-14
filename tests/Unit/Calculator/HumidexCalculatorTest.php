<?php


namespace App\Tests\Unit\Calculator;

use App\Core\Calculator\HumidexCalculator;
use App\Tests\TestCase;

class HumidexCalculatorTest extends TestCase
{
    /**
     * @var HumidexCalculator
     */
    private $humidexCalculator;

    protected function setUp()
    {
        parent::setUp();
        $this->humidexCalculator = self::$container->get(HumidexCalculator::class);
    }

    /**
     * @dataProvider dataProvider
     */
    public function testHumidexCalculator($tempF, $dewPointF, $expected)
    {
        $result = $this->humidexCalculator->getHumidex($tempF, $dewPointF);

        $this->assertEquals($expected, $result);
    }

    public function dataProvider()
    {
        return [
            [
                68.0,
                50.0,
                21.3
            ],
            [
                102.0,
                49.0,
                39.9
            ],
            [
                105.8,
                68.0,
                48.6
            ]
        ];
    }
}