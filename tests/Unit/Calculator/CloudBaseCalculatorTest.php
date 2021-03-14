<?php


namespace App\Tests\Unit\Calculator;

use App\Core\Calculator\CloudBaseCalculator;
use App\Tests\TestCase;

class CloudBaseCalculatorTest extends TestCase
{
    /**
     * @var CloudBaseCalculator
     */
    private $cloudBaseCalculator;

    protected function setUp()
    {
        parent::setUp();
        $this->cloudBaseCalculator = self::$container->get(CloudBaseCalculator::class);
    }

    /**
     * @dataProvider dataProvider
     */
    public function testCloudBaseCalculator($tempF, $dewPointF, $expected)
    {
        $result = $this->cloudBaseCalculator->getCloudBase($tempF, $dewPointF);

        $this->assertEquals($expected, $result);
    }

    public function dataProvider()
    {
        return [
            [
                91.0,
                85.0,
                1364
            ],
            [
                52.0,
                48.0,
                909
            ]
        ];
    }
}