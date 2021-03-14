<?php


namespace App\Tests\Unit\Calculator;

use App\Core\Calculator\WindChillCalculator;
use App\Tests\TestCase;

class WindChillCalculatorTest extends TestCase
{
    /**
     * @var WindChillCalculator
     */
    private $windChillCalculator;

    protected function setUp()
    {
        parent::setUp();
        $this->windChillCalculator = self::$container->get(WindChillCalculator::class);
    }

    /**
     * @dataProvider dataProvider
     */
    public function testWindChillCalculator($tempF, $windspeedMph, $expected)
    {
        $result = $this->windChillCalculator->getWindChill($tempF, $windspeedMph);

        $this->assertEquals($expected, $result);
    }

    public function dataProvider()
    {
        return [
            [
                51.6,
                6.7,
                51.6
            ],
            [
                22.9,
                4.9,
                16.5
            ],
            [
                29.1,
                8.5,
                21.0
            ],
            [
                49.3,
                8.5,
                45.7
            ]
        ];
    }
}