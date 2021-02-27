<?php


namespace App\Tests\Unit\Calculator;

use App\Core\Calculator\BeaufortScaleCalculator;
use App\Tests\TestCase;

class BeaufortScaleCalculatorTest extends TestCase
{
    /**
     * @var BeaufortScaleCalculator
     */
    private $beaufortScaleCalculator;

    protected function setUp()
    {
        parent::setUp();
        $this->beaufortScaleCalculator = self::$container->get(BeaufortScaleCalculator::class);
    }

    /**
     * @dataProvider dataProvider
     */
    public function testBeaufortScaleCalculator($mph, $scale)
    {
        $result = $this->beaufortScaleCalculator->getBeaufortScale($mph);

        $this->assertEquals($scale, $result);
    }

    public function dataProvider()
    {
        return [
            [
                15.66,
                4
            ],
            [
                0.37,
                0
            ],
            [
                3.10,
                1
            ],
            [
                25.47,
                6
            ],
            [
                8.13,
                3
            ],
            [
                5.59,
                2
            ]
        ];
    }
}