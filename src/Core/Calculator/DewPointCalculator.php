<?php

namespace App\Core\Calculator;

use App\Core\Converter\Weather\TemperatureConverter;

class DewPointCalculator
{
    /** @var TemperatureConverter */
    private $temperatureConverter;

    /**
     * DewPointCalculator constructor.
     * @param TemperatureConverter $temperatureConverter
     */
    public function __construct(
        TemperatureConverter $temperatureConverter
    ) {
        $this->temperatureConverter = $temperatureConverter;
    }

    /**
     * @param float $tempF
     * @param int $humidity
     * @return float
     */
    public function getDewPoint(float $tempF, int $humidity)
    {
        $result = $this->temperatureConverter->convertImperialToMetric($tempF);

        $s1 = log($humidity / 100);
        $s2 = ($result * 17.625) / ($result + 243.04);
        $s3 = (17.625 - $s1) - $s2;
        $dp = 243.04 * ($s1 + $s2) / $s3;

        return $this->temperatureConverter->convertMetricToImperial($dp);
    }
}
