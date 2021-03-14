<?php


namespace App\Tests\Unit\Calculator;

use App\Core\Calculator\AqiCalculator;
use App\Tests\TestCase;

class AqiCalculatorTest extends TestCase
{
    /**
     * @var AqiCalculator
     */
    private $aqiCalculator;

    protected function setUp()
    {
        parent::setUp();
        $this->aqiCalculator = self::$container->get(AqiCalculator::class);
    }

    /**
     * @dataProvider dataProvider
     */
    public function testAqiCalculator($pm, $aqi)
    {
        $result = $this->aqiCalculator->getAqi($pm);

        $this->assertEquals($aqi, $result);
    }

    public function dataProvider()
    {
        return [
            [
                55,
                149
            ],
            [
                14,
                55
            ],
            [
                20,
                68
            ],
            [
                64,
                155
            ],
            [
                12,
                50
            ]
        ];
    }
}