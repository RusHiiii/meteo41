<?php


namespace App\Tests\Unit\Calculator;

use App\Core\Calculator\DewPointCalculator;
use App\Tests\TestCase;

class DewPointCalculatorTest extends TestCase
{
    /**
     * @var DewPointCalculator
     */
    private $dewPointCalculator;

    protected function setUp()
    {
        parent::setUp();
        $this->dewPointCalculator = self::$container->get(DewPointCalculator::class);
    }

    /**
     * @dataProvider dataProvider
     */
    public function testDewPointCalculator($tempF, $hum, $expected)
    {
        $result = $this->dewPointCalculator->getDewPoint($tempF, $hum);

        $this->assertEquals($expected, $result);
    }

    public function dataProvider()
    {
        return [
            [
                51.4,
                68,
                41.2
            ],
            [
                20.0,
                65,
                10.1
            ],
            [
                37.5,
                86,
                33.8
            ],
            [
                19.2,
                88,
                16.3
            ]
        ];
    }
}