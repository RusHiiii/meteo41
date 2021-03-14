<?php

namespace App\Core\Calculator;

use App\Core\Converter\WindSpeedConverter;
use App\Core\Exception\OutOfRangeException;

class BeaufortScaleCalculator
{
    private $scale = [
        0 => ['up' => 0.0, 'to' => 1.0],
        1 => ['up' => 1.0, 'to' => 6.0],
        2 => ['up' => 6.0, 'to' => 12.0],
        3 => ['up' => 12.0, 'to' => 20.0],
        4 => ['up' => 20.0, 'to' => 31.0],
        5 => ['up' => 31.0, 'to' => 40.0],
        6 => ['up' => 40.0, 'to' => 51.0],
        7 => ['up' => 51.0, 'to' => 62.0],
        8 => ['up' => 62.0, 'to' => 75.0],
        9 => ['up' => 75.0, 'to' => 89.0],
        10 => ['up' => 89.0, 'to' => 103.0],
        11 => ['up' => 103.0, 'to' => 118.0],
        12 => ['up' => 118.0, 'to' => 200.0]
    ];

    /**
     * @var WindSpeedConverter
     */
    private $windspeedConverter;

    /**
     * BeaufortScaleCalculator constructor.
     * @param WindSpeedConverter $windspeedConverter
     */
    public function __construct(
        WindSpeedConverter $windspeedConverter
    ) {
        $this->windspeedConverter = $windspeedConverter;
    }

    /**
     * @param float $windspeedMph
     * @return int|string
     */
    public function getBeaufortScale(float $windspeedMph)
    {
        $result = $this->windspeedConverter->convertImperialToMetric($windspeedMph);

        foreach ($this->scale as $index => $value) {
            if ($result >= $value['up'] && $result < $value['to']) {
                return $index;
            }
        }

        throw new OutOfRangeException();
    }
}
